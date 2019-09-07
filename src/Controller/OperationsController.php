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
            $codeEnvoi=date("s").date("m").date("Y").date("H").date("i");
            $envoi->setCodeEnvoi($codeEnvoi);
            $envoi->setDateEnvoi(new \DateTime());
            $envoi->setStatut("envoyé");
            $valeur = $envoi->getMontant();
            $frais=$repo->findAllGreaterThanTarifs($valeur);
            $tar = $frais->getValeur();
            $envoi->setCommission($tar);
            $envoi->setEtat(($tar*30)/100);
            $envoi->setWari(($tar*40)/100);
            $envoi->setEtat(($tar*30)/100);
            $envoi->setComEnvoi(($tar*10)/100);
            $envoi->setComRetrait(($tar*20)/100);
            $envoi->setUser($this->getUser());
            $envoi->setType("envoi");
            $envoi->setCompte($this->getUser()->getCompte());

            //  dump($this->getUser());
            //  dump($this->getUser()->getCompte());
            //  dump($envoi->setCompte($this->getUser()->getCompte()));
            //  die();
            


                            
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
            $trouverCode = $this->getDoctrine()->getRepository(Operations::class)->findOneBy(["CodeEnvoi" => $pin]);
            // dump($trouverCode);die();
            if ($trouverCode )
            {
             
              

                        $dest = $trouverCode->getDestinataire();
                        $env = $trouverCode->getEnvoyeur();
                        $som=$trouverCode->getMontant();
                        $tel = $trouverCode->getTelRecepteur();
                        $statut=$trouverCode->getStatut();
                        $commission =$trouverCode->getCommission();
                        $etat = $trouverCode->getEtat();
                        $wari = $trouverCode->getWari();
                        $comEnvoi=$trouverCode->getComEnvoi();
                        $comRetrait = $trouverCode->getComRetrait();

                        //dump($dest);die();
                       
            }
            
            if (!$trouverCode )

            {
               $data = [
                'status' => 400,
                'message' => 'Code n existe pas dans la base'
                ];
            
            return new JsonResponse($data, 400);
            }

            if ($form->isSubmitted() && $form->isValid()) {


                    $compare = $this->getUser()->getCompte()->getSolde();
                    // $caa = $compt->get
                //  dump( $compt);die();
                if ( $compare  <= $som ) {

                    $data = [
                        'status' => 400,
                        'message' => "Solde insuffisant pour exécuter l'opération"
                        ];
                    
                    return new JsonResponse($data, 400);

                              
                
                
                } 
                // dump($trouverCode->getDateRetrait());die();

                if (($trouverCode->getDateRetrait()) == null) {

                    $data = [
                        'status' => 400,
                        'message' => "Code déja retiré"
                        ];
                    
                    return new JsonResponse($data, 400);

    
                }
                else {
                    # code...
              

                $retrait->setDateRetrait(new \DateTime());
                $retrait->setCompte($this->getUser()->getCompte());
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
                $valeur = $newcompte->getSolde()+$trouverCode->getMontant()+$trouverCode->getComRetrait();
                $newcompte->setSolde($valeur);


                $entityManager->persist($newcompte);
                $entityManager->flush();

                $data = [
                    'status' => 201,
                    'message' => 'Retrait validé',
                    'commission' => $retrait->getComRetrait().'  CFA',
                    'nouvel solde' => $newcompte->getSolde().'  CFA'
                ];
                
            return new JsonResponse($data, 201);

            
            }
                $data = [
                    'status' => 400,
                    'message' => 'Operations Impossible'
                ];
                
            return new JsonResponse($data, 400);
        }       
        
    }

      /**   
     * @Route("/codeFinder", name="operation_recherche")
     * 
     * @IsGranted({"ROLE_ADMIN", "ROLE_USER"}, statusCode=404, message="Vous n'avez pas accces")
     */
    public function rechercherCode(Request $request,
    SerializerInterface $serializer,OperationsRepository $repo){

        $retrait = new Operations();
        $form = $this->createForm(RetraitType::class, $retrait);
        $data = $request->request->all();
        $form->submit($data);
    
        $pin = $retrait->getCodeEnvoi();
        // dump($pin);

        $trouverCode = $repo->findOneBy(["CodeEnvoi" => $pin]);
    //  dump($trouverCode);
        if ($trouverCode)
        {
            $donnee = $serializer->serialize($trouverCode, 'json',['groups'=>['retired']]);

            //dump($donnee);
            return new Response($donnee, 200, [
                'Content-Type' => 'application/json'
            ]);
        }
        
}

}