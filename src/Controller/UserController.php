<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
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
//    $email                  = $request->request->get("email");
//    $password               = $request->request->get("password");
//    $passwordConfirmation   = $request->request->get("password_confirmation");


    // $roles = $request->request->get("roles");
    // $nomcomplet = $request->request->get("nomComplet");
    // $propriete = $request->request->get("propriete");
    // $adresse = $request->request->get("adresse");
    // $telephone = $request->request->get("telephone");
    // $statut = $request->request->get("statut");
        // var_dump($data);die();
   $errors = [];
//    if($data && $password != $passwordConfirmation)
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
    //    $user->setEmail(trim($email));
    //    $user->setPassword(trim($encodedPassword));
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
    //    $user->setNomComplet(trim($nomcomplet));
    //    $user->setPropriete(trim($propriete));
    //    $user->setAdresse(trim($adresse));
    //    $user->setTelephone(trim($telephone));
    //    $user->setStatut(trim($statut));

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
     * @Route("/login", name="api_login",  methods={"POST"})
     * 
     */
    public  function login(){
        return $this->json([
            'result' => 'Login validé'
        ]);
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

