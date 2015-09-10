<?php

namespace Self\SeasonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeasonTeam
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Self\SeasonBundle\Entity\SeasonTeamRepository")
 */
class SeasonTeam
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
    * @var integer
    *
    * @ORM\ManyToOne(targetEntity="Self\SeasonBundle\Entity\Season")
    * @ORM\JoinColumn(name="seasonId", referencedColumnName="id")
    **/
    private $season;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Self\SeasonBundle\Entity\Division")
     * @ORM\JoinColumn(name="divisionId", referencedColumnName="id")
     **/
    private $division;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Self\TeamBundle\Entity\Team")
     * @ORM\JoinColumn(name="teamId", referencedColumnName="id")
     **/
    private $team;

    /**
     * @return int
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param int $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="ranking", type="integer")
     */
    private $ranking;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set ranking
     *
     * @param integer $ranking
     * @return SeasonTeam
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;

        return $this;
    }

    /**
     * Get ranking
     *
     * @return integer
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * @return int
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param int $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }

    /**
     * @return int
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * @param int $division
     */
    public function setDivision($division)
    {
        $this->division = $division;
    }
}
