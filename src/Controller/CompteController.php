<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Entity\Partenaire;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
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
        $data=$request->request->all();
        $form->submit($data);
    
        $sol=0;
        $random1 = random_int(101, 999);
        $random11 = random_int(101, 999);
        $random111 = random_int(151, 999);

        $random = ($random1.$random11.$random111);


        $newcompte->setNumCompte($random);
        $newcompte->setSolde($sol);

        // $searchid =$this->getDoctrine()->getRepository(Partenaire::class)->findByNinea($value->ninea);

        // var_dump($searchid);die();
    
        if ($form->isSubmitted() && $form->isValid()) {
        // $newcompte->setPartenaire($searchid[0]);

        $entityManager->persist($newcompte);
        $entityManager->flush();

        $data = [
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
}
