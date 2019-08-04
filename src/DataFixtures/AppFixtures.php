<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setEmail('superadminWari@gmail.com');
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$qOZJi0CHDyQlMPcfHvc3mw$wW1tR26QAogKSJMMBLGt/ofiC7dcK0FweSAufR7vZ4k');
        $user->setNomComplet('admin wari');
        $user->setPropriete('Wari');
        $user->setAdresse('wari city');
        $user->setTelephone('771234569');
        $user->setStatut('actif');
        
        $manager->persist($user);

        $user = new User();

        $user->setEmail('caissierWari@gmail.com');
        $user->setRoles(["ROLE_CAISSIER"]);
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$QEVCBm1tgjiaD1R4i3Q/XA$zU8sh2i5v2Aq/WNh+UxIMFBJYvnHARDHVvCJA76fo2k');
        $user->setNomComplet('caissier wari');
        $user->setPropriete('Wari');
        $user->setAdresse('wari city');
        $user->setTelephone('772142020');
        $user->setStatut('actif');
 
        $manager->persist($user);
 
        $manager->flush();
        
    }
}
