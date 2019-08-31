<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\RetraitType;
use App\Entity\Operations;
use App\Form\OperationsType;
use Doctrine\ORM\EntityManager;
use App\Repository\TarifsRepository;
use App\Repository\OperationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 * 
 */
class OperationsController extends AbstractController
{
    /**
     * @Route("/envoi", name="operation_envoi", methods={"POST"})
     * 
     * @IsGranted({"ROLE_ADMIN", "ROLE_USER"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function envoi(Request $request, EntityManagerInterface $entityManager,
    SerializerInterface $serializer, ValidatorInterface $validator,TarifsRepository $repo)
    {
        $envoi = new Operations();

        $form = $this->createForm(OperationsType::class,$envoi);
    
        $data = $request->request->all();

        $form->submit($data);

       
        if($form->isSubmitted() && $form->isValid()) 
        
        {
            $envoi->setDateEnvoi(new \DateTime());
            $envoi->setStatut("envoyé");
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
            $valeur = $newcompte->getSolde()-$envoi->getMontant()+$envoi->getComEnvoi();
                
            if ($valeur <= '5000') 
            {

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
                    'frais' => $tar.' CFA',
                    'nouvel solde' => $newcompte->getSolde().' CFA',
                    'commission propre'=> $envoi->getComEnvoi().' CFA'
                    
                 ];
                
            return new JsonResponse($data, 201);
        }
                $data = [
                    'status' => 400,
                    'message' => 'Transaction pas ok'
                ];
            
            return new JsonResponse($data, 400);
    }

    /**
     * @Route("/retrait", name="operation_retrait", methods={"POST"})
     * 
     * @IsGranted({"ROLE_ADMIN", "ROLE_USER"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function retrait(Request $request, EntityManagerInterface $entityManager,
    SerializerInterface $serializer, ValidatorInterface $validator,OperationsRepository $repo)
        {

            $retrait = new Operations();
            $form = $this->createForm(RetraitType::class, $retrait);
            $data = $request->request->all();
            $form->submit($data);
        
            $pin = $retrait->getCodeEnvoi();
            $trouverCode = $this->getDoctrine()->getRepository(Operations::class)->findByCodeEnvoi($pin);

            if ($trouverCode)
            {
                
                $dest = $trouverCode[0]->getDestinataire();
                $env = $trouverCode[0]->getEnvoyeur();
                $som=$trouverCode[0]->getMontant();
                $tel = $trouverCode[0]->getTelRecepteur();
                $statut=$trouverCode[0]->getStatut();
                $commission =$trouverCode[0]->getCommission();
                $etat = $trouverCode[0]->getEtat();
                $wari = $trouverCode[0]->getWari();
                $comEnvoi=$trouverCode[0]->getComEnvoi();
                $comRetrait = $trouverCode[0]->getComRetrait();


            }

            if (!$trouverCode)

            {
               $data = [
                'status' => 400,
                'message' => 'Code n existe pas dans la base'
                ];
            
            return new JsonResponse($data, 400);
            }

            if ($form->isSubmitted() && $form->isValid()) {

                $retrait->setDateRetrait(new \DateTime());
                $retrait->setStatut("retiré");
                $retrait->setType("retrait");
                $retrait->setUser($this->getUser());
                $retrait->setMontant($som);
                $retrait->setCommission($commission);
                $retrait->setComEnvoi($comEnvoi);
                $retrait->setComRetrait($comRetrait);
                $retrait->setEtat($etat);
                $retrait->setWari($wari);
                $retrait->setDestinataire($dest);
                $retrait->setTelRecepteur($tel);


                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($retrait);
            
            
                $newcompte = $retrait->getCompte();
                $valeur = $newcompte->getSolde()+$trouverCode[0]->getMontant()+$trouverCode[0]->getComRetrait();
                $newcompte->setSolde($valeur);


                $entityManager->persist($newcompte);
                $entityManager->flush();

                $data = [
                    'status' => 201,
                    'message' => 'ok',
                    'commission' => $retrait->getComRetrait().'  CFA',
                    'nouvel solde' => $newcompte->getSolde().'  CFA'
                ];
                
            return new JsonResponse($data, 201);

            
            }
                $data = [
                    'status' => 400,
                    'message' => 'pas ok'
                ];
                
            return new JsonResponse($data, 400);
        }       
        
    


    
}
