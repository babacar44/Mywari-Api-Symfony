<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Form\UserType;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\PartenaireRepository;
use App\Repository\UserRepository;

/**
 * @Route("/api")
 * 
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire", name="partenaire", methods ={"POST"})
     * 
     * @IsGranted({"ROLE_SUPER_ADMIN", "ROLE_ADMIN_WARI"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function createPartenaire(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder)
    {
        /**
         *
         */
        //  $value = json_decode($request->getContent());
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        $data = json_decode($request->getContent(), true);
        $data = $request->request->all();

        // dump($data);die();
        $form->submit($data);

        $show = $this->getUser();
dump($show);die();
        $random1 = random_int(001, 999);
        $random2 = random_int(001, 999);
        $random3 = random_int(151, 999);

        $random = $random1 . $random2 . $random3;
        $randomNinea = strval($random1 . $random2);

        $partenaire->setNinea($randomNinea);
        $partenaire->setStatut("actif");


        $errors = $validator->validate($partenaire);

        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $compte = new Compte();

            $som = 0;
            $random1 = random_int(001, 999);
            $random2 = random_int(001, 999);
            $random3 = random_int(151, 999);

            $random = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s");

            $randomNinea = strval($random1 . $random2);

            $compte->setnumCompte($random);
            $compte->setSolde($som);
            $compte->setPartenaire($partenaire);
            $errors = $validator->validate($compte);

            if (count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
            $entityManager->persist($partenaire);
            $entityManager->flush();

            $em = $this->getDoctrine()->getManager();
            $em->persist($compte);
            $em->flush();
            $data = [

                'status' => 201,
                'message' => 'Le partenaire a bien été ajouté'
            ];
            $user = new User();

            $user->setEmail($partenaire->getEmail());
            $user->setRoles(["ROLE_ADMIN_PARTENER"]);
            $user->setPassword($passwordEncoder->encodePassword($user, 'passer'));
            $user->setNomComplet($partenaire->getNomComplet());
            $user->setPropriete($partenaire->getRaisonSociale());
            $user->setAdresse($partenaire->getAdresse());
            $user->setTelephone($partenaire->getTelephone());
            $user->setStatut("actif");
            $user->setPartenaire($partenaire);

            
            // $part = $this->getUser()->getPartenaire();
            // dump($part);
            // $user->setPartenaire($part);

            $errors = $validator->validate($user);

            if (count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            return new JsonResponse($data, 201);
        }
    }

    /**
     * @Route("/listerpartenaire", name="partenaire_liste", methods={"GET"})
     *
     * @IsGranted({"ROLE_SUPER_ADMIN", "ROLE_ADMIN_WARI"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function list(PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
        $partenaire = $partenaireRepository->findAll();

        $data = $serializer->serialize($partenaire, 'json',['groups'=>['partener']]);

      
        return new Response(
            $data,
            200,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @Route("/listerpart/{id}", name="parteanire_update", methods= {"GET"})
     * @IsGranted({"ROLE_SUPER_ADMIN", "ROLE_ADMIN_WARI"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function update(Request $request, SerializerInterface $serializer, Partenaire $partenaire, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {

        // dump($partenaire);
        /* $partenaireUpdate = $entityManager->getRepository(Partenaire::class)->find($partenaire->getId());
        $data = json_decode($request->getContent()); */
        // dump($partenaire->getStatut());
        // dump($partenaire->getId());
        // dump($this->getUser());
        //$ess=$this->getUser()->getStatut();
        // dump( $ess=$this->getUser()->getStatut());
        if ($partenaire->getStatut() == "actif") {
            $partenaire->setStatut("bloquer");
        
        }

        elseif ($partenaire->getStatut() == "bloquer") {
            $partenaire->setStatut("actif");
        }
    
        // dump($partenaire->getStatut());

        // dump($ess);die();

        // if (is_array($data) || is_object($data)) {
        //     foreach ($data as $key => $value) {
        //         if ($key && !empty($value)) { 

        //             $name = ucfirst($key);
        //             $setter = 'set' . $name;

        //             $partenaireUpdate->$setter($value);
        //         }
        //     }
        // }
        // $errors = $validator->validate($partenaireUpdate);
        // if (count($errors)) {
        //     $errors = $serializer->serialize($errors, 'json',['groups'=>['partener']]);
        //     return new Response($errors, 500, [
        //         'Content_Type' => 'application/json'
        //     ]);
        // }
        // $entityManager->persist($ess);
        $entityManager->flush();
        $data = [
            'status' => 200,
            'message' => 'Le partenaire a bien été mis à jour'

        ];
        return new JsonResponse($data);
    }

       /**
     * @Route("/listerpartener/{id}", name="partenaire_liste_id", methods={"GET"})
     *
     * @IsGranted({"ROLE_SUPER_ADMIN", "ROLE_ADMIN_WARI"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function listbyid(PartenaireRepository $partenaireRepository,Partenaire $partenaire, SerializerInterface $serializer)
    {
        $partenaireGet = $partenaireRepository->find($partenaire->getId());

        $data = $serializer->serialize($partenaireGet, 'json',['groups'=>['partener']]);

      
        return new Response(
            $data,
            200,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }


    //  /**
    //  * @Route("/listerUser", name="partenaire_liste", methods={"GET"})
    //  *
    //  * @IsGranted({"ROLE_SUPER_ADMIN", "ROLE_ADMIN_WARI"}, statusCode=404, message="Vous n'avez pas accces")
    //  */
    // public function listUser(UserRepository $userRepository, SerializerInterface $serializer)
    // {
    //     $partenaire = $userRepository->findAll();

    //     $data = $serializer->serialize($partenaire, 'json',['groups'=>['partener']]);


    //     return new Response(
    //         $data,
    //         200,
    //         [
    //             'Content-Type' => 'application/json'
    //         ]
    //     );
    // }


}
