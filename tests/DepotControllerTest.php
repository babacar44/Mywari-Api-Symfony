<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepotControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'caissierWari@gmail.com',
            'PHP_AUTH_PW'=>'passer'
         ]);      
         $crawler = $client->request('POST', '/api/depot',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
                "montant" : 5000000,
                "caissier" : "caissier wari",
                "depot_id" : 63

         }');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());
        }
    
}
