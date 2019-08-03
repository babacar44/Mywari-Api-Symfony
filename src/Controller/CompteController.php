<?php

namespace App\Controller;

use App\Entity\Compte;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Partenaire;

/**
 * @Route("/api")
 */

class CompteController extends AbstractController
{
    /**
     * @Route("/addcompte", name="creer_compte", methods={"POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function creer(Request $request)
    {
        
    }
}
