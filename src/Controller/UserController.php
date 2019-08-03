<?php

namespace App\Controller;

use App\Entity\User;
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
     * @Route("/ajout", name="admin_register", methods={"POST"})
     * @("IsGranted('ROLE_SUPER_ADMIN')" || "IsGranted('ROLE_ADMIN')")
     * 
     */
    public function register(ObjectManager $om, UserPasswordEncoderInterface $passwordEncoder,ValidatorInterface $validator, Request $request)
    {
        $user = new User();
   $email                  = $request->request->get("email");
   $password               = $request->request->get("password");
   $passwordConfirmation   = $request->request->get("password_confirmation");


    $roles = $request->request->get("roles");
    $nomcomplet = $request->request->get("nomComplet");
    $propriete = $request->request->get("propriete");
    $adresse = $request->request->get("adresse");
    $telephone = $request->request->get("telephone");
    $statut = $request->request->get("statut");

   $errors = [];
   if($password != $passwordConfirmation)
   {
       $errors[] = "Password does not match the password confirmation.";
   }
   if(strlen($password) < 6)
   {
       $errors[] = "Password should be at least 6 characters.";
   }
   if(!$errors)
   {
       $encodedPassword = $passwordEncoder->encodePassword($user, $password);
       $user->setEmail($email);
       $user->setPassword($encodedPassword);
    if ($this->get("security.authorization_checker")->isGranted("ROLE_SUPER_ADMIN")) {
        $user->setRoles(["ROLE_ADMIN"]);
    }
    else  {
            $user->setRoles(["ROLE_USER"]);
    } 
       $user->setNomComplet($nomcomplet);
       $user->setPropriete($propriete);
       $user->setAdresse($adresse);
       $user->setTelephone($telephone);
       $user->setStatut($statut);

       $entityErrors = $validator->validate($user);
        if(count($entityErrors) == 0)
        {
            // Save entity
            $om->persist($user);
            $om->flush();
                return $this->json([
                    'user' => $user,
                    'status' => 201,
                'message' => 'L\' AdminPartenaire a été créé'
                ]);
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

    /**
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @Route("/profile", name="api_profile")
     * 
     */
    public function profile()
    {
        return $this->json([
            'user' => $this->getUser()
        ], 200, [], [
            'groups' => ['api']
        ]);
    }

    /**
     * @Route("/", name="api_home")
     */
    public function home()
    {
    return $this->json(['result' => true]);
    }
 }

