<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/09/15
 * Time: 22:08
 */

namespace SCLeague\SeasonBundle\Tests\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use SCLeague\SeasonBundle\Entity\Division;
use SCLeague\SeasonBundle\Entity\Season;
use SCLeague\SeasonBundle\Entity\SeasonTeam;
use SCLeague\SeasonBundle\Entity\SeasonTeamRepository;
use SCLeague\SeasonBundle\Model\SeasonTeamManager;
use SCLeague\TeamBundle\Entity\Team;

class SeasonTeamManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SeasonTeamManager
     */
    private $seasonTeamManager;
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp()
    {
        parent::setUp();
        $this->getEmMock();
        $this->seasonTeamManager = new SeasonTeamManager(new ArrayCollection(array(new DummyDivision(), new DummyDivision())), $this->entityManager);
        $teams = new ArrayCollection(array(new DummyTeam(), new DummyTeam()));
        $this->seasonTeamManager->addTeam($teams, new DummyDivision());
    }

    /**
     * @test
     */
    public function it_should_persist_season_team()
    {

        $this->seasonTeamManager->manageTeamsForSeason(new DummySeason());

        $this->entityManager->expects($this->any())
            ->method('persist')
            ->with($this->equalTo('SCLeague\SeasonBundle\Tests\Model\DummySeasonTeam'))
            ->will($this->returnValue(null));
        $this->entityManager->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));
    }

    /**
     *
     */
    protected function getEmMock()
    {
        $this->entityManager  = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'persist', 'flush'), array(), '', false);
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