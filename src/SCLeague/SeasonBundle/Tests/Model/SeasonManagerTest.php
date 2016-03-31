<?php

namespace SCLeague\SeasonBundle\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use SCLeague\SeasonBundle\Entity\SeasonTeam;
use SCLeague\SeasonBundle\Model\SeasonManager;
use SCLeague\SeasonBundle\Tests\Entity\DummyDivision;
use SCLeague\SeasonBundle\Tests\Entity\DummySeason;
use SCLeague\SeasonBundle\Tests\Entity\DummySeasonTeam;
use SCLeague\SeasonBundle\Tests\Entity\DummyTeam;

/**
 * @coversDefaultClass \SCLeague\SeasonBundle\Model\SeasonManager
 */
class SeasonManagerTest extends PHPUnit_Framework_TestCase
{

    const SEASON_CLASS = 'SCLeague\SeasonBundle\Tests\Entity\DummySeason';
    const TEAM_CLASS = 'SCLeague\SeasonBundle\Tests\Entity\DummyTeam';
    const DIVISION_CLASS = 'SCLeague\SeasonBundle\Tests\Entity\DummyDivision';
    const SEASONTEAM_CLASS = 'SCLeague\SeasonBundle\Tests\Entity\DummySeasonTeam';


    /**
     * @var SeasonManager
     */
    protected $seasonManager;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp() {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run');
        }

        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');


        $this->seasonManager = $this->createSeasonManager($this->om);
    }

    /**
     * @test
     * @covers ::getSeason
     */
    public function it_should_return_null_when_no_previous_season() {
        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::SEASON_CLASS))
            ->will($this->returnValue($this->repository));

        $id = 0;
        $this->repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->will($this->returnValue(null));

        $season = $this->seasonManager->getSeason($id);
        $this->assertNull($season);
    }


    /**
     * @test
     * @covers ::getSeason
     */
    public function it_should_return_a_season() {
        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::SEASON_CLASS))
            ->will($this->returnValue($this->repository));

        $season = $this->getSeason();
        $id = 1;
        $this->repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->will($this->returnValue($season));

        $seasonObject = $this->seasonManager->getSeason($id);

        $this->assertEquals($season, $seasonObject);
    }

    /**
     * @test
     * @covers ::getSeasonTeams
     */
    public function it_should_return_all_season_teams() {
        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::SEASONTEAM_CLASS))
            ->will($this->returnValue($this->repository));

        $season = $this->getSeason();
        $seasonTeams = $this->getSeasonTeams(2);
        $this->repository->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue($seasonTeams));

        $all = $this->seasonManager->getSeasonTeams($season);

        $this->assertEquals($seasonTeams, $all);
    }

    /**
     * @test
     * @covers ::getDivisions
     */
    public function it_should_return_all_divisions() {
        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::DIVISION_CLASS))
            ->will($this->returnValue($this->repository));

        $divisions = $this->getDivisions();
        $this->repository->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue($divisions));

        $allDivisions = $this->seasonManager->getDivisions();
        $this->assertEquals($divisions, $allDivisions);
    }

    /**
     * @test
     *
     */
    public function it_should_return_the_next_division() {

        $divisions = $this->setupDivision();
        $nextDivision = $this->invokeMethod($this->seasonManager, 'getNextDivision' , array($divisions, 'Platinum'));
        $this->assertEquals($nextDivision->getName(), 'Diamond');
    }

    /**
     * @test
     */
    public function it_should_return_the_current_division() {

        $divisions = $this->setupDivision();
        $currentDivision = $this->invokeMethod($this->seasonManager, 'getCurrentDivision', array($divisions, 'Diamond'));
        $this->assertEquals($currentDivision, $divisions->get(0));
    }

    /**
     * @test
     */
    public function it_should_return_the_previous_division() {

        $divisions = $this->setupDivision();
        $previousDivision = $this->invokeMethod($this->seasonManager, 'getPreviousDivision', array($divisions, 'Master'));
        $this->assertEquals($previousDivision->getName(), 'Diamond');
    }

    /**
     * @test
     */
    public function it_should_return_all_teams_by_division() {
        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::SEASONTEAM_CLASS))
            ->will($this->returnValue($this->repository));

        $seasonsTeams = $this->getSeasonTeams();
        /** @var SeasonTeam $seasonTeam */
        foreach ($seasonsTeams as $seasonTeam) {
            $seasonTeam->setTeam(new DummyTeam());
        }
        $this->repository->expects($this->atLeastOnce())
            ->method('findBy')
            ->will($this->returnValue($seasonsTeams));

        $teams = $this->seasonManager->getAllTeamsForDivision(new DummyDivision(), new DummySeason());
        $this->assertContainsOnlyInstancesOf('\SCLeague\SeasonBundle\Tests\Entity\DummyTeam', $teams);
    }

    /**
     * @test
     */
    public function it_should_return_an_array_of_divisions_containing_teams() {

        $dummySeasonTeam = new DummySeasonTeam();
        $division = new DummyDivision();
        $division->setName('Gold');
        $dummySeasonTeam->setDivision($division);
        $dummySeasonTeam->setTeam(new DummyTeam());
        $dummySeasonTeam->setRanking(1);

        $dummySeasonTeam2 = new DummySeasonTeam();
        $dummySeasonTeam2->setDivision($division);
        $dummySeasonTeam2->setTeam(new DummyTeam());
        $dummySeasonTeam2->setRanking(2);

        $dummySeasonTeam3 = new DummySeasonTeam();
        $dummySeasonTeam3->setDivision($division);
        $dummySeasonTeam3->setTeam(new DummyTeam());
        $dummySeasonTeam3->setRanking(3);
        
        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::SEASONTEAM_CLASS))
            ->will($this->returnValue($this->repository));

        $this->repository->expects($this->atLeastOnce())
            ->method('findBy')
            ->will($this->returnValue(array($dummySeasonTeam, $dummySeasonTeam2, $dummySeasonTeam3)));
        
        $teamsByDivision = $this->seasonManager->sortTeamByDivision(new DummySeason());
        foreach($teamsByDivision as $team) {
            $this->assertContainsOnlyInstancesOf('SCLeague\SeasonBundle\Tests\Entity\DummyTeam', $team);
        }

    }
    
    



    private function getDivisions()
    {
        $divisions = array();
        for($i = 0; $i < 3; $i++) {
            $divisions[] = $this->getDivision();
        }
        return $divisions;
    }

    private function getSeason()
    {
        $seasonClass = static::SEASON_CLASS;
        return new $seasonClass();
    }

    private function getSeasonTeams($maxSeasonTeams = 4)
    {
        $seasonTeams = array();
        for($i = 0; $i < $maxSeasonTeams; $i++) {
            $seasonTeams[] = $this->getSeasonTeam();
        }
        return new ArrayCollection($seasonTeams);
    }

    private function getSeasonTeam()
    {
        $seasonTeamClass = static::SEASONTEAM_CLASS;
        return new $seasonTeamClass();
    }

    private function createSeasonManager($objectManager)
    {
        return new SeasonManager($objectManager, static::SEASON_CLASS, static::TEAM_CLASS, static::DIVISION_CLASS, static::SEASONTEAM_CLASS);
    }

    private function getDivision()
    {
        $divisionClass = static::DIVISION_CLASS;
        return new $divisionClass();
    }

    private function setupDivision()
    {
        $masterDivision = new DummyDivision();
        $masterDivision->setName('Master');
        $diamondDivision = new DummyDivision();
        $diamondDivision->setName('Diamond');
        $diamondDivision->setNextDivision($masterDivision);
        $platinumDivision = new DummyDivision();
        $platinumDivision->setName('Platinum');
        $platinumDivision->setNextDivision($diamondDivision);

        return new ArrayCollection(array($diamondDivision, $masterDivision, $platinumDivision));
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }


}