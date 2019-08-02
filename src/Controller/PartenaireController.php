<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Partenaire;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/api")
 * 
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire", name="partenaire", methods ={"POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     * 
     */
    public function createPartenaire(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        /**
         * @var Serializer $serializer
         */

         $serializer = $this->get('serializer');
         $partenaire = $serializer->deserialize($request->getContent(), Partenaire::class, 'json');
         $em = $this->getDoctrine()->getManager();
         $em->persist($partenaire);
         $em->flush();
         $data = [
             
            'status' => 201,
            'message' => 'Le partenaire a bien été ajouté'
        ];
        
         $user = new User();
        $user-> setEmail($partenaire->getEmail());
        $user-> setRoles(["ROLE_ADMIN"]);
        $user-> setPassword($passwordEncoder->encodePassword($user, 'passer'));
        $user-> setNomComplet($partenaire->getNomComplet());
        $user-> setPropriete($partenaire->getRaisonSociale());
        $user-> setAdresse($partenaire->getAdresse());
        $user-> setTelephone($partenaire->getTelephone());
        $user-> setStatut("actif");

         $em->persist($user);
         $em->flush();
         return new JsonResponse($data, 201);
        }
}
