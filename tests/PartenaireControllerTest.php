<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartenaireControllerTest extends WebTestCase
{
    public function testCreatePartenaire()
    {
        $client = static::createClient([],[
        'PHP_AUTH_USER'=>'superadminWari@gmail.com',
        'PHP_AUTH_PW'=>'123'
     ]);      
     $crawler = $client->request('POST', '/api/partenaire',[],[],
    ['CONTENT_TYPE'=>"application/json"],
    '{
        "raisonSociale":"Ndiaye & Frere service",
        "nomComplet":"Ndiaye Kimora",
        "telephone": "777454175",
        "email":"guissenidaye@gmail.com",
        "adresse" : "dakar"
        
     }');
    $rep=$client->getResponse();
    var_dump($rep);
    $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
}
