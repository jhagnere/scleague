<?php

namespace Self\SeasonBundle\Tests\Model;

use PHPUnit_Framework_TestCase;
use Self\SeasonBundle\Entity\Division;
use Self\SeasonBundle\Entity\Season;
use Self\SeasonBundle\Entity\SeasonTeam;
use Self\SeasonBundle\Model\SeasonManager;
use Self\TeamBundle\Entity\Team;

class SeasonManagerTest extends PHPUnit_Framework_TestCase
{

    const SEASON_CLASS = 'SCLeague\SeasonBundle\Tests\Model\DummySeason';
    const TEAM_CLASS = 'SCLeague\SeasonBundle\Tests\Model\DummyTeam';
    const DIVISION_CLASS = 'SCLeague\SeasonBundle\Tests\Model\DummyDivision';
    const SEASONTEAM_CLASS = 'SCLeague\SeasonBundle\Tests\Model\DummySeasonTeam';


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

        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');





        $this->seasonManager = $this->createSeasonManager($this->om);
    }

    /**
     * @test
     */
    public function it_should_return_seasons() {
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

    public function testGetAllSeasonTeams() {
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



    public function testGetPreviousSeason() {

    }




    private function getSeason()
    {
        $seasonClass = static::SEASON_CLASS;
        return new $seasonClass();
    }

    private function getSeasonTeams($maxSeasonTeams = 4)
    {
        $seasonTeams[] = array();
        for($i = 0; $i < $maxSeasonTeams; $i++) {
            $seasonTeams[] = $this->getSeasonTeam();
        }
        return $seasonTeams;
    }

    private function getTeam()
    {
        $teamClass = static::TEAM_CLASS;
        return new $teamClass();
    }

    private function getDivision()
    {
        $divisionClass = static::DIVISION_CLASS;
        return new $divisionClass();
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


}

class DummySeason extends Season
{
}

class DummyTeam extends Team
{
}

class DummyDivision extends Division
{
}
class DummySeasonTeam extends SeasonTeam
{
}
