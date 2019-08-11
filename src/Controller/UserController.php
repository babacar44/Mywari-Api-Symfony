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
     * @("IsGranted('ROLE_SUPER_ADMIN')" || "IsGranted('ROLE_ADMIN_PARTENER')")
     * 
     */
    public function register(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder,ValidatorInterface $validator, Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $data=$request->request->all();
        $file = $request->files->all()[
            "imageName"
        ];
        $form->submit($data);

   $errors = [];
        if ($data && ($request->request->get("password") != $request->request->get("password_confirmation")) )
        
   {
       $errors[] = "Password does not match the password confirmation.";
   }
   if(strlen($request->request->get("password")) < 6)
   {
       $errors[] = "Password should be at least 6 characters.";
   }


   if(!$errors)
   {
       $encodedPassword = $passwordEncoder->encodePassword($user, $request->request->get("password"));
  
    $user->setPassword(
        $passwordEncoder->encodePassword(
            $user,
            $form->get('password')->getData()
        ));
    
    if ($this->get("security.authorization_checker")->isGranted("ROLE_SUPER_ADMIN")) {
        $user->setRoles(["ROLE_ADMIN_WARI"]);
    }
    else  {
            $user->setRoles($roles);
    } 


       $entityErrors = $validator->validate($user);
        if(count($entityErrors) == 0)
        {        if ($form->isSubmitted() ) {

            $user->setImageFile($file);

            // Save entity
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
                return $this->json([
                    'user' => $user,
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
                return new JsonResponse(['veuillez saisir un mot de pass']);
            }
            if ($user->getStatut()=='bloquer') {

                return new JsonResponse(['Veuillez contacter votre administrateur vous etes bloqué']);
        }

        
        $token = $jwtEncoder->encode([
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

