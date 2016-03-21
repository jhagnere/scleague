<?php

namespace SCLeague\TeamBundle\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use SCLeague\SeasonBundle\Entity\Season;
use SCLeague\TeamBundle\Entity\Game;
use SCLeague\TeamBundle\Entity\Team;

class GameManager
{

    /** @var EntityManager */
    private $entityManager;


    public function __construct($em) {
        $this->entityManager = $em;
    }

    public function generateGame(Season $season, Team $teamHome, Team $teamAway)
    {
        $game = new Game();
        $game->setSeason($season);
        $game->setTeamHome($teamHome);
        $game->setTeamAway($teamAway);
        $game->setChannel($teamHome->getShortName().'vs'.$teamAway->getShortName());

        return $game;
    }

    /**
     * @param $teams
     * @param $season
     * @return ArrayCollection Games
     */
    public function generateAllGames($teams, $season)
    {
        $games = new ArrayCollection();
        foreach ($teams as $key => $team) {
            $teamHome = $team;
            unset($teams[$key]);
            foreach($teams as $teamToPlayAgainst) {
                $games->add($this->generateGame($season, $teamHome, $teamToPlayAgainst));
            }
        }
        return $games;
    }

    public function filterGames(ArrayCollection &$arrayOfGames)
    {
        $actualGame = $arrayOfGames->first();
        $actualGame->first = true;
        $entrySet = new ArrayCollection();
        $entrySet->add($actualGame);

        foreach ($arrayOfGames as $game) {
            if ($game != $actualGame) {
                if (($actualGame->getTeamHome() != $game->getTeamAway()) &&  ($actualGame->getTeamAway() != $game->getTeamAway())) {
                    if (($actualGame->getTeamHome() != $game->getTeamHome()) && ($actualGame->getTeamAway() != $game->getTeamHome())) {
                        if (!isset($game->skipped)) {
                            // Try to find if one team of this game is already playing for the week
                            foreach ($entrySet as $entry) {
                                if ($game->getTeamHome()->getName() == $entry->getTeamHome()->getName() || ($game->getTeamHome()->getName() == $entry->getTeamAway()->getName())) {
                                       $notMatch = true;
                                } else {
                                    if ($game->getTeamAway()->getName() == $entry->getTeamHome()->getName() || ($game->getTeamAway()->getName() == $entry->getTeamAway()->getName())) {
                                        $notMatch = true;
                                    }
                                }
                            }
                            if (!isset($notMatch)) {
                                $entrySet->add($game);
                                $game->test = true;
                                $actualGame = $game;
                            } else {
                                unset($notMatch);
                            }
                        }
                    }
                }
            }

        }

        return $entrySet;
    }

    public function sortGamesPerDate(ArrayCollection $arrayOfGames, $numberOfTeams)
    {
        $gamesPerWeek = new ArrayCollection();
        $arrayOfGames->count();
        $i = 0;
        while(!($arrayOfGames->isEmpty())) {
            $temporaryGamesSet = $this->filterGames($arrayOfGames);
            if ($temporaryGamesSet->count() != ( $numberOfTeams / 2)) {
                // Case where the number of games is too much (one team playing twice in a week)
                foreach($temporaryGamesSet as $gameSet) {
                    if (isset($gameSet->test) && $gameSet->test && !isset($gameSet->skipped)) {
                        $gameSet->skipped = true;
                    }
                }
            } else {
                $gamesPerWeek->add($temporaryGamesSet);
                foreach ($temporaryGamesSet as $gameSet) {
                    $arrayOfGames->removeElement($gameSet);
                }
                foreach($arrayOfGames as $games) {
                    if (isset($games->test)) {
                        unset($games->test);
                    }
                    if (isset($games->skipped)) {
                        unset($games->skipped);
                    }
                }

            }
            $i++;
        }

        return $gamesPerWeek;
    }

    public function generateDatesForGames(ArrayCollection $gamesPerDate, Season $season)
    {
        try {
            $dates = array();
            $countNbOfGames = $gamesPerDate->count();
            $seasonStartDate = $season->getStartDate()->getTimestamp();
            $seasonOfficialStartDate = new \DateTime();
            $seasonOfficialStartDate->setTimestamp($seasonStartDate);
            $seasonOfficialStartDate->add(new \DateInterval('P3D'));
            $interval = $seasonOfficialStartDate->diff($season->getEndDate());
            $aGameEveryXDay = intval($interval->days / $countNbOfGames);
            for ($i = 0; $i < $countNbOfGames; $i++) {
                    $newDate = $seasonOfficialStartDate->add(new \DateInterval('P' . $aGameEveryXDay . 'D'))->getTimestamp();
                    $dates[$i] = new \DateTime();
                    $dates[$i]->setTimestamp($newDate);

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit(1);
        }
        return $dates;
    }

    public function addDateToGames(&$gamesPerDate, $dates)
    {
        foreach ($gamesPerDate as $key => $gamePerWeek) {
            foreach($gamePerWeek as $game) {
                $game->setGameDate($dates[$key]);
            }
        }
    }

    public function persistGames($gamesPerDate)
    {
        try {
            foreach ($gamesPerDate as $key => $gamePerWeek) {
                /** @var $game Game */
                foreach ($gamePerWeek as $game) {
                    $this->entityManager->persist($game);
                }
            }
            $this->entityManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit(1);
        }

    }


}