<?php

namespace Self\SeasonBundle\Tests\Controller;

use DateTime;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SeasonControllerTest extends WebTestCase
{

    private $client = null;

    private $admin = null;

    public function setUp()
    {
        $classes = array(
            'Self\UserBundle\DataFixtures\ORM\LoadUserData'
        );
        $this->loadFixtures($classes);
        $this->client = static::makeClient(true);
    }



    public function testSeasonCreate() {
        $route =  $this->getUrl('admin_self_season_season_list');
        $crawler = $this->client->request('GET', $route);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), "Unexpected HTTP status code for GET admin/sef/season/season/list");
        $crawler = $this->client->click($crawler->selectLink('Add new')->link());


        $form = $crawler->selectButton('Create and return to list')->form();
        $uri = $form->getUri();
        $uniqid = explode('=', $uri)[1];
        /**
         * @TODO : Better way to fill date ?
         */
        $form[''.$uniqid.'[name]'] = 'Season 1';
        $form[''.$uniqid.'[startDate]']['date']['year']->setValue('2015');
        $form[''.$uniqid.'[startDate]']['date']['month']->setValue('1');
        $form[''.$uniqid.'[startDate]']['date']['day']->setValue('1');
        $form[''.$uniqid.'[endDate]']['date']['year']->setValue('2015');
        $form[''.$uniqid.'[endDate]']['date']['month']->setValue('12');
        $form[''.$uniqid.'[endDate]']['date']['day']->setValue('25');

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('td:contains("Season 1")')->count(), 'Missing element td:contains("Season 1")');

    }
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/season/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /season/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'self_seasonbundle_season[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'self_seasonbundle_season[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
