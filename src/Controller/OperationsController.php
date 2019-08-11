<?php

namespace App\Controller;

use App\Entity\Operations;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OperationsController extends AbstractController
{
    /**
     * @Route("/operations", name="operations")
     */
    public function envoi(Request $request, EntityManager $entityManager)
    {
        $envoi = new Operations();

        $form = $this->createFormBuilder(Operations::class, $envoi);
        $form->handleRequest($request);
        $data = $request->request->all();

        $form->submit($data);

        if ($form->isSubmitted && $form->isValid) {
               $envoi->setDateEnvoi(new \DateTime());

               
                
        }



    }
}
