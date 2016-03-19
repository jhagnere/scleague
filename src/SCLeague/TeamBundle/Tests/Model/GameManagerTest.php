<?php

namespace SCLeague\TeamBundle\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use SCLeague\SeasonBundle\Entity\Season;
use SCLeague\TeamBundle\Entity\Game;
use SCLeague\TeamBundle\Entity\Team;
use SCLeague\TeamBundle\Model\GameManager;

/**
 * @coversDefaultClass \SCLeague\TeamBundle\Model\GameManager
 */
class GameManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var GameManager
     */
    private $gameManager;


    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $entityManager;


    protected function setUp()
    {
        parent::setUp();
        $this->getEmMock();

        $this->gameManager = new GameManager($this->entityManager);

    }

    /**
     * @test
     */
    public function it_should_be_an_instance_of_game()
    {
        $season = new DummySeason();
        $teamHome = new DummyTeam();
        $teamAway = new DummyTeam();

        $game = $this->gameManager->generateGame($season, $teamHome, $teamAway);
        $this->assertInstanceOf('SCLeague\TeamBundle\Entity\Game', $game);
    }

    /**
     * @test
     */
    public function it_should_generate_all_the_games_for_a_given_season()
    {
        list($season, $teams) = $this->setUpForGames();
        $arrayOfGames = $this->gameManager->generateAllGames($teams, $season);
        // We assert that each team is playing the others only once.
        $this->assertCount(10, $arrayOfGames);
        $this->assertContainsOnlyInstancesOf('SCLeague\TeamBundle\Entity\Game', $arrayOfGames);
    }

    /**
     * @test
     */
    public function it_should_return_a_given_amount_of_games() {
        list($arrayOfGames) = $this->setUpGameDate();

        $gameDateToSet = $this->gameManager->filterGames($arrayOfGames);
        $this->assertCount(3, $gameDateToSet);
    }

    /**
     * @test
     */
    public function it_should_return_all_games_per_date() {
        list($arrayOfGames, $numberOfTeams) = $this->setUpGameDate();

        $gamesPerDate = $this->gameManager->sortGamesPerDate($arrayOfGames, $numberOfTeams);
        $this->assertCount(5, $gamesPerDate);
    }

    /**
     * @test
     */
    public function it_should_have_the_same_amount_of_games_per_date() {
        list($arrayOfGames, $numberOfTeams) = $this->setUpGameDate();

        $gamesPerDate = $this->gameManager->sortGamesPerDate($arrayOfGames, $numberOfTeams);
        foreach($gamesPerDate as $games) {
            $this->assertCount(3, $games);
        }
    }

    private function getEmMock()
    {
        $this->entityManager = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'persist', 'flush'), array(), '', false);
    }

    /**
     * @return array
     */
    private function setUpForGames()
    {
        $season = new DummySeason();

        $dummyTeam1 = new DummyTeam();
        $dummyTeam1->setName('Team 1');
        $dummyTeam2 = new DummyTeam();
        $dummyTeam2->setName('Team 2');
        $dummyTeam3 = new DummyTeam();
        $dummyTeam3->setName('Team 3');
        $dummyTeam4 = new DummyTeam();
        $dummyTeam4->setName('Team 4');
        $dummyTeam5 = new DummyTeam();
        $dummyTeam5->setName('Team 5');

        $teams = array($dummyTeam1, $dummyTeam2, $dummyTeam3, $dummyTeam4, $dummyTeam5);
        return array($season, $teams);
    }

    private function setUpGameDate()
    {
        $season = new DummySeason();
        $dummyTeam1 = new DummyTeam();
        $dummyTeam1->setName('Team 1');
        $dummyTeam2 = new DummyTeam();
        $dummyTeam2->setName('Team 2');
        $dummyTeam3 = new DummyTeam();
        $dummyTeam3->setName('Team 3');
        $dummyTeam4 = new DummyTeam();
        $dummyTeam4->setName('Team 4');
        $dummyTeam5 = new DummyTeam();
        $dummyTeam5->setName('Team 5');
        $dummyTeam6 = new DummyTeam();
        $dummyTeam6->setName('Team 6');

        $game1 = new Game();
        $game1->setSeason($season);
        $game1->setTeamHome($dummyTeam1);
        $game1->setTeamAway($dummyTeam2);

        $game2 = new Game();
        $game2->setSeason($season);
        $game2->setTeamHome($dummyTeam1);
        $game2->setTeamAway($dummyTeam3);

        $game3 = new Game();
        $game3->setSeason($season);
        $game3->setTeamHome($dummyTeam1);
        $game3->setTeamAway($dummyTeam4);

        $game4 = new Game();
        $game4->setSeason($season);
        $game4->setTeamHome($dummyTeam1);
        $game4->setTeamAway($dummyTeam5);

        $game5 = new Game();
        $game5->setSeason($season);
        $game5->setTeamHome($dummyTeam1);
        $game5->setTeamAway($dummyTeam6);

        $game6 = new Game();
        $game6->setSeason($season);
        $game6->setTeamHome($dummyTeam2);
        $game6->setTeamAway($dummyTeam3);

        $game7 = new Game();
        $game7->setSeason($season);
        $game7->setTeamHome($dummyTeam2);
        $game7->setTeamAway($dummyTeam4);

        $game8 = new Game();
        $game8->setSeason($season);
        $game8->setTeamHome($dummyTeam2);
        $game8->setTeamAway($dummyTeam5);

        $game9 = new Game();
        $game9->setSeason($season);
        $game9->setTeamHome($dummyTeam2);
        $game9->setTeamAway($dummyTeam6);

        $game10 = new Game();
        $game10->setSeason($season);
        $game10->setTeamHome($dummyTeam3);
        $game10->setTeamAway($dummyTeam4);

        $game11 = new Game();
        $game11->setSeason($season);
        $game11->setTeamHome($dummyTeam3);
        $game11->setTeamAway($dummyTeam5);

        $game12 = new Game();
        $game12->setSeason($season);
        $game12->setTeamHome($dummyTeam3);
        $game12->setTeamAway($dummyTeam6);

        $game13 = new Game();
        $game13->setSeason($season);
        $game13->setTeamHome($dummyTeam4);
        $game13->setTeamAway($dummyTeam5);

        $game14 = new Game();
        $game14->setSeason($season);
        $game14->setTeamHome($dummyTeam4);
        $game14->setTeamAway($dummyTeam6);

        $game15 = new Game();
        $game15->setSeason($season);
        $game15->setTeamHome($dummyTeam5);
        $game15->setTeamAway($dummyTeam6);


        $arrayOfGames = new ArrayCollection();
        $arrayOfGames->add($game1);
        $arrayOfGames->add($game2);
        $arrayOfGames->add($game3);
        $arrayOfGames->add($game4);
        $arrayOfGames->add($game5);
        $arrayOfGames->add($game6);
        $arrayOfGames->add($game7);
        $arrayOfGames->add($game8);
        $arrayOfGames->add($game9);
        $arrayOfGames->add($game10);
        $arrayOfGames->add($game11);
        $arrayOfGames->add($game12);
        $arrayOfGames->add($game13);
        $arrayOfGames->add($game14);
        $arrayOfGames->add($game15);


        return array($arrayOfGames, 6);
    }


}

class DummySeason extends Season
{
}

class DummyTeam extends Team
{
}
