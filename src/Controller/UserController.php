<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/register", name="api_register", methods={"POST"})
     */
    public function register(ObjectManager $om, UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        $user = new User();

        //recuperation des donnees saisies
        $email                  = $request->request->get("email");
        $password               = $request->request->get("password");
        $passwordConfirmation   = $request->request->get("password_confirmation");
        $roles                  = $request->request->get("roles");

        $errors = [];

        if ($password != $passwordConfirmation) {
            $errors[] = "Les Mots de passe ne correspondent pas";
        }
        if (strlen($password) < 6) {
            $errors[] = "Le mot de passe doit etre supérieur à 6 caracteres";
        }

        if (!$errors)
        {
            
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setEmail($email);
            $user->setPassword($encodedPassword);
            $user->setRoles($roles);
            
            try {
             
                $om->persist($user);
                $om->flush();

                return $this->json([
                    'user' => $user
                ]);

            } catch (UniqueConstraintViolationException $e) {
              
                $errors[] = "L'email saisi existe deja dans la base";
            }
            catch(\Exception $e)
            {
                $errors[] = "Unable to save new user at this time.";
            }
        }

        return $this->json([
            'errors' => $errors
        ], 400);

    }
    /**
     * @Route("/login", name="api_login",  methods={"POST"})
     */
    public  function login(){
        return $this->json([
            'result' => true
        ]);
    }

    /**
     * @Route("/profile", name="api_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profil(){
        return $this->json([
            'user' => $this->getUser()
        ]);
    }
 }

