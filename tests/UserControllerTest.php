<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient([],[
                    'PHP_AUTH_USER'=>'superadminWari@gmail.com',
                    'PHP_AUTH_PW'=>'123'
                 ]);      
                 $crawler = $client->request('POST', '/api/inscription',[],[],
                ['CONTENT_TYPE'=>"application/json"],
                '{
                    "email" : "yacine33@gmail.com",
                    "password" : "passer",
                    "password_confirmation" : "passer",
                    "nomComplet" : "yacine Sow ",
                    "propriete" : "Yacine Service",
                    "adresse" : "dakar",
                    "telephone" : "772046114",
                    "statut" : "actif"
                    
                 }');
                $rep=$client->getResponse();
                var_dump($rep);
                $this->assertSame(200,$client->getResponse()->getStatusCode());
    }
    
}
