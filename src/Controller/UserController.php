<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;



/**
 * @Route("/api")
 */
class UserController extends AbstractController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/inscription", name="admin_register", methods={"POST"})
     *
     * @IsGranted({"ROLE_SUPER_ADMIN", "ROLE_ADMIN_PARTENER"}, statusCode=404, message="Vous n'avez pas accces")
     * 
     */
    public function register(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder,ValidatorInterface $validator, Request $request)
    {
        /**
         * on instancie la classe User dans notre controller
         */
        $user = new User();

            /**
             * on cree un form et on la binde avec l objet $user
             */
        $form = $this->createForm(UserType::class, $user);

        /**
         * handleRequest, $data recuperent toutes les 
         * donnees envoyé depuis le formulaire
         * $file recupere les images envoyé 
         * 
         */
        $form->handleRequest($request);
        $data=$request->request->all();
        $file = $request->files->all()[
            "imageName"
        ];
        /**
         * submit valide les donnees recu par $data
         */
        $form->submit($data);

        /**
         * ici on cree un tableau d'erreur pour capter les erreurs et envoye divers message selon l'erreur
         */
   $errors = [];
   /**
    * mot de passe doit = mot de passe de confirmation
    */
        if ($data && ($request->request->get("password") != $request->request->get("passwordConfirmation")) )
        
   {    
       $errors[] = "Password does not match the password confirmation.";
   }

   /**
    * mot de passe doit etre superieur ou = à 6
    */
   if(strlen($request->request->get("password")) < 6)
   {
       $errors[] = "Password should be at least 6 characters.";
   }

    /**
     * et si c est le superAdmin WARI , il fournit le role ADMIN ou CAIISER
     */
    if (($this->get("security.authorization_checker")->isGranted("ROLE_SUPER_ADMIN")))
    
    {
        if ($user->getProfil() == '1') 
        {
            $user->setRoles(["ROLE_ADMIN_WARI"]);
        }

        elseif ($user->getProfil() == '2')
        {
            $user->setRoles(["ROLE_CAISSIER"]);
        }

        else 
        {
            $errors[] = "roles n existe pas ";   
        } 
    } 

    /**
     * et si c est le superAdmin Partenaire , il fournit le role ADMIN ou USER
     */

    if (($this->get("security.authorization_checker")->isGranted("ROLE_ADMIN_PARTENER")))

    {
        if ($user->getProfil() == '1') 
        {
            $user->setRoles(["ROLE_ADMIN"]);
        }

        elseif ($user->getProfil() == '2')
        {
            $user->setRoles(["ROLE_USER"]);
        }

        else 
        {
            $errors[] = "roles n existe pas ";   
        } 
    }   
        

    /**
     * s'il n'ya pas d erreur  on encode le password
     */
   if(!$errors)
   {
    //    $encodedPassword = $passwordEncoder->encodePassword($user, $request->request->get("password"));
  
    $user->setPassword(
        $passwordEncoder->encodePassword(
            $user,
            $form->get('password')->getData()
        ));

        /**
         * si c l superAdmin qui est bien connecté il ne peut inscrire que fournir le role de ROLE_ADMIN_WARI
         */
    
    


       $entityErrors = $validator->validate($user);
        if(count($entityErrors) == 0)
        {        if ($form->isSubmitted() ) {

            $user->setImageFile($file);

            // Save entity
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
                return $this->json([
                    'status' => 200,
                'message' => 'L\' Utilisateur a été créé'
            
                ]);
            }
        }
            else
        {
            foreach($entityErrors as $error)
        {
            $errors[] = $error->getMessage();
        }
                }
        }
        return $this->json([
            'errors' => $errors
        ], 400);
        }

   
        /**
         * @Route("/login", name="token", methods={"POST"})
         * @param Request $request
         * @param JWTEncoderInterface $JWTEncoder
         * @return JsonResponse
         * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
         */

        public function login(Request $request, JWTEncoderInterface $jwtEncoder)
        {

            $values=json_decode($request->getContent());
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                'email' => $values->email,
            ]);

            if (!$user) {
                return new JsonResponse(['l\utilisateur n\'existe pas']);
            }

            $isValid = $this->passwordEncoder->isPasswordValid($user, $values->password);

            if (!$isValid) {
                return new JsonResponse(['veuillez saisir un mot de passe']);
            }
            if ($user->getStatut()=='bloquer') {

                return new JsonResponse(['Veuillez contacter votre administrateur vous etes bloqué']);
        }

        
        $token = $jwtEncoder->encode([
                'roles' => $user->getRoles(),
                'email' => $user->getEmail(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        return new JsonResponse(['token' => $token]);
    }


    // /**
    //  * @IsGranted("ROLE_SUPER_ADMIN")
    //  * @Route("/profile", name="api_profile")
    //  * 
    //  */
    // public function profile()
    // {
    //     return $this->json([
    //         'user' => $this->getUser()
    //     ], 200, [], [
    //         'groups' => ['api']
    //     ]);
    // }

    /**
     * @Route("/", name="api_home")
     */
    public function home()
    {
    return $this->json(['result' => true]);
    }
    
    




}

