<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/09/15
 * Time: 02:21
 */

namespace SCLeague\SeasonBundle\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use SCLeague\SeasonBundle\Entity\Division;
use SCLeague\SeasonBundle\Entity\Season;
use SCLeague\SeasonBundle\Entity\SeasonTeam;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;

class SeasonTeamManager implements TeamManagerInterface
{

    private $divisions;

    private $seasonTeams;
    private $entityManager;

    /**
     * @param ArrayCollection $divisions
     * @param EntityManager $em
     */
    public function __construct(ArrayCollection $divisions, EntityManager $em) {
        $this->divisions = $divisions;
        $this->entityManager = $em;
        $this->seasonTeams = new ArrayCollection();
    }

    public function addTeam(ArrayCollection $teams, Division $division) {
        $key = $division->getName();
        if ($this->seasonTeams->get($key) != null) {
            $this->seasonTeams->get($key)->add($teams);
        } else {
            $this->seasonTeams->set($key, $teams);
        }

    }

    /**
     * Create the new entities to persist in DB concerning the season
     * @param Season $season
     */
    public function manageTeamsForSeason(Season $season)
    {
        foreach ($this->seasonTeams->getIterator() as $divisionName => $teams) {
            $division = $this->extractDivision($divisionName);
            try {
                $ranking = 1;
                foreach ($teams->getIterator() as $team) {
                    $st = new SeasonTeam();
                    $st->setDivision($division);
                    $st->setRanking($ranking++);
                    $st->setTeam($team);
                    $st->setSeason($season);
                    $this->entityManager->persist($st);

                }
                $this->entityManager->flush();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

    }



    /**
     * @param string $divisionName
     * @return Division
     *
     */
    private function extractDivision($divisionName)
    {
        return $this->divisions->filter(
        /**
         * @param Division $entry
         * @return Division
         */
            function ($entry) use ($divisionName) {
                if ($divisionName == $entry->getName()) {
                    return $entry;
                }
        })->first();
    }


}