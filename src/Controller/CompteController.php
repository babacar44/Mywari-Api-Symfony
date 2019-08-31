<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
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

/**
 * @Route("/api")
 */

class CompteController extends AbstractController
{
    /**
     * @Route("/addcompte", name="creer_compte", methods={"POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function creer(Request $request, EntityManagerInterface $entityManager)
    {
        // $value = json_decode($request->getContent());
        $newcompte = new Compte();
        $form = $this->createForm(CompteType::class, $newcompte);
        $form->handleRequest($request);
        //$data=json_decode($request->getContent(),true);
        $data = $request->request->all();
        $form->submit($data);

        $sol = 0;
        $random1 = random_int(101, 999);
        $random11 = random_int(101, 999);
        $random111 = random_int(151, 999);

        $random = ($random1 . $random11 . $random111);


        $newcompte->setNumCompte($random);
        $newcompte->setSolde($sol);


        if ($form->isSubmitted() && $form->isValid()) {
            // $newcompte->setCompte($searchid[0]);

            $entityManager->persist($newcompte);
            $entityManager->flush();

            $data = [
                'user'  => $newcompte->getId(),
                'status' => 201,
                'message' => 'Compte Crée'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Echec Création Réesaayer !'
        ];
        return new JsonResponse($data, 500);
    }

    /**
     * @Route("/listercompte", name="compte_liste", methods={"GET"})
     *
     * @IsGranted({"ROLE_CAISSIER", "ROLE_SUPER_ADMIN"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function list(CompteRepository $compteRepository, SerializerInterface $serializer)
    {
        $newcompte = $compteRepository->findAll();

        $data = $serializer->serialize($newcompte, 'json');


        return new Response(
            $data,
            200,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
