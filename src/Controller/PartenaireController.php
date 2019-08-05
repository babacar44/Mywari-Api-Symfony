<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Entity\Partenaire;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/api")
 * 
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire", name="partenaire", methods ={"POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     * 
     */
    public function createPartenaire(Request $request, SerializerInterface $serializer,ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder )
    {
        /**
         *
         */
        $serializer = $this->get('serializer');
        $compte = $serializer->deserialize($request->getContent(), Compte::class ,'json');
      


        $som=0;
        $random1 = random_int(001, 999);
        $random2 = random_int(001, 999);
        $random3 = random_int(151, 999);

        $random = $random1.$random2.$random3;
        $randomNinea =strval($random1.$random2);
        
        $compte->setnumCompte($random);
        $compte->setSolde($som);

        $errors = $validator->validate($compte);

        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }

        $em =$this->getDoctrine()->getManager();
        $em->persist($compte);
        $em->flush();

        $value = json_decode($request->getContent());
        $partenaire = new Partenaire();
        $partenaire->setNinea($randomNinea);
        $partenaire->setRaisonSociale($value->raisonSociale);
        $partenaire->setNomComplet($value->nomComplet);
        $partenaire->setTelephone($value->telephone);
        $partenaire->setEmail($value->email);
        $partenaire->setAdresse($value->adresse);
        $partenaire->addPartenaire($compte);

        $errors = $validator->validate($partenaire);

        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }

        $em->persist($partenaire);
        $em->flush();
        $data = [
           
            'status' => 201,
            'message' => 'Le partenaire a bien été ajouté'
        ];
        
         $user = new User();
        $user->setEmail($partenaire->getEmail());
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($passwordEncoder->encodePassword($user, 'passer'));
        $user->setNomComplet($partenaire->getNomComplet());
        $user->setPropriete($partenaire->getRaisonSociale());
        $user->setAdresse($partenaire->getAdresse());
        $user->setTelephone($partenaire->getTelephone());
        $user->setStatut("actif");

        $errors = $validator->validate($user);

        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }


        $em =$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
         

         return new JsonResponse($data, 201);
        }

       

}
