<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/09/15
 * Time: 22:08
 */

namespace SCLeague\SeasonBundle\Tests\Model;


use Doctrine\Common\Collections\ArrayCollection;
use SCLeague\SeasonBundle\Model\SeasonTeamManager;
use SCLeague\SeasonBundle\Tests\Entity\DummyDivision;
use SCLeague\SeasonBundle\Tests\Entity\DummySeason;
use SCLeague\SeasonBundle\Tests\Entity\DummyTeam;

/**
 * @coversDefaultClass \SCLeague\SeasonBundle\Model\SeasonTeamManager
 */
class SeasonTeamManagerTest extends \PHPUnit_Framework_TestCase
{

    const SEASONTEAM_CLASS = 'SCLeague\SeasonBundle\Tests\Entity\DummySeasonTeam';



    /**
     * @var SeasonTeamManager
     */
    private $seasonTeamManager;


    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $entityManager;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->getEmMock();

        $dummyDivision = new DummyDivision();
        $dummyDivision->setName('Gold');
        $teams = new ArrayCollection(array(new DummyTeam(), new DummyTeam()));

        $this->seasonTeamManager = new SeasonTeamManager(new ArrayCollection(array($dummyDivision, new DummyDivision())), $this->entityManager);
        $this->seasonTeamManager->addTeam($teams, new DummyDivision());

    }

    /**
     * @test
     */
    public function it_should_persist_season_teams()
    {

        $this->entityManager->expects($this->atLeastOnce())
            ->method('persist');

        $this->entityManager->expects($this->exactly(1))
            ->method('flush');


        $this->seasonTeamManager->manageTeamsForSeason(new DummySeason());

    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function it_should_throw_an_exception()
    {
        $this->entityManager->expects($this->any())
            ->method('flush')
            ->will($this->throwException(new \Exception('Unable to flush season teams')));

        $this->seasonTeamManager->manageTeamsForSeason(new DummySeason());
    }

    /**
     * @test
     */
    public function it_should_return_a_division() {

        $division = $this->invokeMethod($this->seasonTeamManager, 'extractDivision', array('Gold'));
        $this->assertInstanceOf('SCLeague\SeasonBundle\Entity\Division', $division);
    }



    protected function getEmMock()
    {
        $this->entityManager  = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'persist', 'flush'), array(), '', false);
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