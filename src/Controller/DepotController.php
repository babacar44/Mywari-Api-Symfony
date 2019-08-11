<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Form\DepotType;
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

        $depot = new Depot();
        $form=$this->createForm(DepotType::class,$depot);
        // $data=json_decode($request->getContent(),true);

        $data=$request->request->all();

        $form->submit($data);

            $errors = $validator->validate($depot);


        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        if($form->isSubmitted() && $form->isValid()){
        $depot->setDateDepot(new \DateTime());



        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($depot);
        $entityManager->flush();
        
        $newcompte = $depot->getDepot();
        $valeur = $newcompte->getSolde()+ $depot->getMontant();
        $newcompte->setSolde($valeur);
        $entityManager->persist($newcompte);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => 'Dépot de '.$depot->getMontant().' validé'
        ];
        
        return new JsonResponse($data, 201);
    }
    $data = [
        'status' => 400,
        'message' => 'Dépot pas ok'
    ];
    
    return new JsonResponse($data, 400);
    }
}
