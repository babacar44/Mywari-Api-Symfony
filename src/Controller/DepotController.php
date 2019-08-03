<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
 * @IsGranted("ROLE_CAISSIER")
 */
class DepotController extends AbstractController
{
    /**
     * @Route("/depot", name="depot")
     */
    public function deposer(Request $request, EntityManagerInterface $entityManager,SerializerInterface $serializer, ValidatorInterface $validator)
    {

        $values = json_decode($request->getContent());
            $depot = new Depot();

                $depot->setMontant($values->montant);
                $depot->setDateDepot(new \DateTime());
                $depot->setCaissier($values->caissier);
                    $searchId =$this->getDoctrine()->getRepository(Compte::class)->find($values->depot_id);

                    $searchId->setSolde($searchId->getSolde() + $values->montant);

            $depot->setDepot($searchId);

            $errors = $validator->validate($depot);

        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->persist($depot);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => 'Dépot'
        ];
        
        return new JsonResponse($data, 201);

    }
}
