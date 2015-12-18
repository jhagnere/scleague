<?php

namespace SCLeague\SeasonBundle\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class SeasonManager implements SeasonManagerInterface
{

    private $teamClass;
    private $seasonClass;
    private $divisionClass;
    private $seasonTeamClass;
    private $om;

    const UPGRADE_TEAM_NUMBER = 2;
    const DOWNGRADE_TEAM_NUMBER = 2;

    private $divisions = array();


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
        $this->divisions = new ArrayCollection($this->getDivisions());
        $season = $this->getSeason($id);
        $previousSeason = $this->getPreviousSeason((int) $id - 1);
        $seasonTeams =  new ArrayCollection($this->getSeasonTeams($previousSeason));
        $arrayByDivisions = array();


       // Create an array with division name keys to help slice after
        foreach ($seasonTeams as $seasonTeam) {
            $arrayByDivisions[$seasonTeam->getDivision()->getName()][$seasonTeam->getRanking()] = $seasonTeam->getTeam();
        }

        $stm = new SeasonTeamManager($this->divisions, $this->om);
        
        // We stock the last x and best x to make them up/down division for the next season
        foreach ($arrayByDivisions as $division => $team) {
            $nbToKeepInDivision = (int) count($team) - (self::UPGRADE_TEAM_NUMBER + self::DOWNGRADE_TEAM_NUMBER);
            $stm->addTeam(new ArrayCollection(array_slice($team, 0, self::UPGRADE_TEAM_NUMBER)), $this->getNextDivision($division));
            $stm->addTeam(new ArrayCollection(array_slice($team, self::UPGRADE_TEAM_NUMBER, $nbToKeepInDivision)), $this->getCurrentDivision($division));
            $stm->addTeam(new ArrayCollection(array_slice($team, -(self::DOWNGRADE_TEAM_NUMBER), self::DOWNGRADE_TEAM_NUMBER)), $this->getPreviousDivision($division));

            $stm->manageTeamsForSeason($season);
        }

        //@TODO : Generate matches base on team in the same division




        /**
         * @TODO : Case No upper div and lower div
         * @TODO : case of season 1 ??
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

    public function getSeason($id)
    {
        return $this->om->getRepository($this->seasonClass)->find($id);
    }

    public function getDivisions()
    {
        return $this->om->getRepository($this->divisionClass)->findAll();
    }


    public function getSeasonTeams($season)
    {
        return $this->om->getRepository($this->seasonTeamClass)->findBy(array('season' => $season), array('division' => 'ASC', 'ranking' => 'ASC' ));
    }

    public function getNextDivision($division)
    {
         $next = $this->divisions->filter(function ($entry) use ($division) {
            if ($entry->getName() == $division) {
                return $entry;
            }
        });
        return $next->first()->getNextDivision();
    }

    private function getCurrentDivision($division)
    {
        return $this->divisions->filter(function ($entry) use ($division) {
            if ($entry->getName() == $division) {
                return $entry;
            }
        })->first();
    }

    private function getPreviousDivision($division)
    {
        return $this->divisions->filter(function ($entry) use ($division) {
            if ($entry->getNextDivision() != null && $entry->getNextDivision()->getName() == $division) {
                return $entry;
            }
        })->first();
    }

    private function getPreviousSeason($id)
    {
        return $this->om->getRepository($this->seasonClass)->find($id);
    }
}