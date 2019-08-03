<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Depot;
use Doctrine\ORM\EntityManager;
use App\Entity\Compte;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api")
 * 
 */
class DepotController extends AbstractController
{
    /**
     * @Route("/depot", name="depot")
     */
    public function deposer(Request $request, EntityManagerInterface $entityManager)
    {

    $values = json_decode($request->getContent());
        $depot = new Depot();

        $depot->setMontant($values->montant);
        $depot->setDateDepot(new \DateTime());
        $depot->setCaissier($values->caissier);
        $searchId =$this->getDoctrine()->getRepository(Compte::class)->find($values->depot_id);

        $searchId->setSolde($searchId->getSolde() + $values->montant);

        $depot->setDepot($searchId);
        $entityManager->persist($depot);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => 'Dépot'
        ];
        
        return new JsonResponse($data, 201);

    }
}
