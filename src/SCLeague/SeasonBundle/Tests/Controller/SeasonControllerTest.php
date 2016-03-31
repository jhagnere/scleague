<?php

namespace SCLeague\SeasonBundle\Tests\Controller;

use DateTime;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SeasonControllerTest extends WebTestCase
{

    private $client = null;


    public function setUp()
    {
        $classes = array(
            'SCLeague\SeasonBundle\DataFixtures\ORM\LoadDivisionData',
            'SCLeague\SeasonBundle\DataFixtures\ORM\LoadSeasonData',
            'SCLeague\UserBundle\DataFixtures\ORM\LoadUserData'
        );
        $this->loadFixtures($classes);
        $this->client = static::makeClient(true);
    }



    public function testSeasonCreate() {
        $route =  $this->getUrl('admin_scleague_season_season_list');
        $crawler = $this->client->request('GET', $route);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), "Unexpected HTTP status code for GET admin/sef/season/season/list");
        $crawler = $this->client->click($crawler->selectLink('Add new')->link());


        $form = $crawler->selectButton('Create and return to list')->form();
        $uniqid = $this->getUniqid($form);
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

    public function testSeasonLaunch() {
        $route =  $this->getUrl('admin_scleague_season_season_list');
        $crawler = $this->client->request('GET', $route);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), "Unexpected HTTP status code for GET admin/self/season/season/list");

        $crawler = $this->client->click($crawler->selectLink('Launch')->link());
    }

    /**
     * @param $form
     * @return mixed
     */
    private function getUniqid($form)
    {
        $uri = $form->getUri();
        $uniqid = explode('=', $uri)[1];
        return $uniqid;
    }

        // Check the entity has been delete on the list
//        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());

}
