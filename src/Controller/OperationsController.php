<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Operations;
use App\Form\OperationsType;
use Doctrine\ORM\EntityManager;
use App\Repository\TarifsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 * 
 */
class OperationsController extends AbstractController
{
    /**
     * @Route("/operation", name="operation_envoi", methods={"POST"})
     */
    public function operation(Request $request, EntityManagerInterface $entityManager,
    SerializerInterface $serializer, ValidatorInterface $validator,TarifsRepository $repo)
    {
        $envoi = new Operations();

        $form = $this->createForm(OperationsType::class,$envoi);
        // $values=json_decode($request->getContent());
        // dump($form);
        // $searchId =$this->getDoctrine()->getRepository(Compte::class)->findByNumCompte($values->numCompte);

        // $form->handleRequest($request);
        $data = $request->request->all();

        $form->submit($data);

        // $envoi->setUser( $this->getUser());
        // if ($envoi->getType()== '1') {
        //  $envoi->setType("envoi");
        // }
        // if ($envoi->getType()== '2') {
        //  $envoi->setType("envoi");
        // }

        // $errors = $validator->validate($envoi);


        // if(count($errors)) {
        //     $errors = $serializer->serialize($errors, 'json');
        //     return new Response($errors, 500, [
        //         'Content-Type' => 'application/json'
        //     ]);
        // }

        
        // dump($tar);
        if($form->isSubmitted() && $form->isValid()) {
               $envoi->setDateEnvoi(new \DateTime());

               $valeur = $envoi->getMontant();
               $frais=$repo->findAllGreaterThanTarifs($valeur);
               $tar = $frais[0]->getValeur();
               $envoi->setCommission($tar);
               $envoi->setEtat(($tar*30)/100);
               $envoi->setWari(($tar*40)/100);
               $envoi->setEtat(($tar*30)/100);
               $envoi->setComEnvoi(($tar*10)/100);
               $envoi->setComRetrait(($tar*20)/100);
                $envoi->setUser($this->getUser());
               $envoi->setType("envoi");
                            
               $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($envoi);
                $entityManager->flush();
             
                $newcompte = $envoi->getCompte();
                $valeur = $newcompte->getSolde()-$envoi->getMontant();
                if ($valeur <= '5000') {

                    $data = [
                        'status' => 400,
                        'message' => 'Solde insuffisant pour faire un envoi. Solde ne peut pas etre <=5000 FCFA. Veuillez faire un depot au niveau de l agence'
                    ];
                    
                    return new JsonResponse($data, 400);
                        }
                $newcompte->setSolde($valeur);

                
                $entityManager->persist($newcompte);
                $entityManager->flush();

                $data = [
                    'status' => 201,
                    'message' => 'Transaction de '.$envoi->getMontant().' validée',
                    'nouvel solde' => $newcompte->getSolde().' Francs CFA'
                ];
                
                return new JsonResponse($data, 201);
        }
            $data = [
                'status' => 400,
                'message' => 'Transaction pas ok'
            ];
            
            return new JsonResponse($data, 400);
            
        
               
    }



    
}
