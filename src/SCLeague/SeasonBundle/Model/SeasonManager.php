<?php

namespace SCLeague\SeasonBundle\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use SCLeague\SeasonBundle\Entity\Division;
use SCLeague\SeasonBundle\Entity\Season;
use SCLeague\SeasonBundle\Entity\SeasonTeam;
use SCLeague\TeamBundle\Model\GameManager;

class SeasonManager implements SeasonManagerInterface
{

    private $teamClass;
    private $seasonClass;
    private $divisionClass;
    private $seasonTeamClass;
    private $om;

    const UPGRADE_TEAM_NUMBER = 2;
    const DOWNGRADE_TEAM_NUMBER = 2;


    public function __construct(ObjectManager $om, $seasonClass, $teamClass, $divisionClass, $seasonTeamClass)
    {
        $this->om = $om;
        $this->seasonClass = $seasonClass;
        $this->teamClass = $teamClass;
        $this->divisionClass = $divisionClass;
        $this->seasonTeamClass = $seasonTeamClass;

    }

    /**
     * @param $id
     * @return string
     */
    public function launchSeason($id)
    {

        $previousSeason = $this->getSeason((int) $id - 1);
        $gameManager = new GameManager($this->om);
        // Case of previous season already exist
        if ($previousSeason != null) {
            $season = $this->getSeason($id);
            $divisions = new ArrayCollection($this->getDivisions());
            $seasonTeams =  new ArrayCollection($this->getSeasonTeams($previousSeason));

            $teamsByDivision = array();
            // Create an array with division name keys to help slice after
            foreach ($seasonTeams as $seasonTeam) {
                $teamsByDivision[$seasonTeam->getDivision()->getName()][$seasonTeam->getRanking()] = $seasonTeam->getTeam();
            }
            $stm = new SeasonTeamManager($divisions, $this->om);

            // We stock the last x and best x to make them up/down division for the next season
            foreach ($teamsByDivision as $division => $team) {
                $nbToKeepInDivision = (int) count($team) - (self::UPGRADE_TEAM_NUMBER + self::DOWNGRADE_TEAM_NUMBER);
                $stm->addTeam(new ArrayCollection(array_slice($team, 0, self::UPGRADE_TEAM_NUMBER)), $this->getNextDivision($divisions, $division));
                $stm->addTeam(new ArrayCollection(array_slice($team, self::UPGRADE_TEAM_NUMBER, $nbToKeepInDivision)), $this->getCurrentDivision($divisions, $division));
                $stm->addTeam(new ArrayCollection(array_slice($team, -(self::DOWNGRADE_TEAM_NUMBER), self::DOWNGRADE_TEAM_NUMBER)), $this->getPreviousDivision($divisions, $division));

                $stm->manageTeamsForSeason($season);
            }
            // Generate matches base on team in the same division
            foreach ($divisions as $division) {
                try {
                    $teams = $this->getAllTeamsForDivision($division, $season);
                    if (count($teams) >= 2 ) {
                        $games = $gameManager->generateAllGames($teams, $season);
                        $gamesPerDate = $gameManager->sortGamesPerDate($games, count($teams));
                        $dates = $gameManager->generateDatesForGames($gamesPerDate, $season);
                        $gameManager->addDateToGames($gamesPerDate, $dates);
                        $gameManager->persistGames($gamesPerDate);
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    exit(1);
                }
            }
        } else {
            // Case for the first season
        }









        /**
         * @TODO : Case No upper div and lower div
         *
         */
        return 'Season Launched';
    }

    public function closeSeason($id)
    {
        /**
         * @TODO : close the season into database
         * @TODO : freeze games from this season
         * @TODO : ??
         */
    }

    /**
     * @param $id
     * @return Season $season
     */
    public function getSeason($id)
    {
        $season = $this->om->getRepository($this->seasonClass)->find($id);
        if ($season === null) {
            // log season doesn't exist to retrieved season with id : ".$id);
        }
        return $season;
    }

    public function getDivisions()
    {
        return $this->om->getRepository($this->divisionClass)->findAll();
    }


    public function getSeasonTeams($season)
    {
        return $this->om->getRepository($this->seasonTeamClass)->findBy(array('season' => $season), array('division' => 'ASC', 'ranking' => 'ASC' ));
    }

    private function getNextDivision(ArrayCollection $divisions, $division)
    {
         $next = $divisions->filter(function (Division $entry) use ($division) {
            if ($entry->getName() == $division) {
                return $entry;
            }
        });
        return $next->first()->getNextDivision();
    }

    private function getCurrentDivision(ArrayCollection $divisions, $division)
    {
        return $divisions->filter(function (Division $entry) use ($division) {
            if ($entry->getName() == $division) {
                return $entry;
            }
        })->first();
    }

    private function getPreviousDivision(ArrayCollection $divisions, $division)
    {
        return $divisions->filter(function (Division $entry) use ($division) {
            if ($entry->getNextDivision() != null && $entry->getNextDivision()->getName() == $division) {
                return $entry;
            }
        })->first();
    }

    /**
     * @param Division $division
     * @param Season $season
     * @return array of Teams
     */
    public function getAllTeamsForDivision($division, $season)
    {
        $teams = array();
        $listSeasonTeams =  $this->om->getRepository($this->seasonTeamClass)->findBy(array('season' => $season, 'division' => $division));
        /** @var SeasonTeam $seasonTeams */
        foreach ($listSeasonTeams as $seasonTeams) {
            $teams[] = $seasonTeams->getTeam();
        }
        return $teams;
    }

}