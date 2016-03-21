<?php

namespace SCLeague\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SCLeague\SeasonBundle\Entity\Season;

/**
 * Game
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="season_game_unique", columns={"seasonId", "teamIdHome", "teamIdAway"})}))
 * @ORM\Entity(repositoryClass="SCLeague\TeamBundle\Entity\GameRepository")
 */
class Game
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
     * @ORM\ManyToOne(targetEntity="SCLeague\SeasonBundle\Entity\Season")
     * @ORM\JoinColumn(name="seasonId", referencedColumnName="id")
     */
    private $season;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="gameDate", type="datetime")
     */
    private $gameDate;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="teamIdHome", referencedColumnName="id")
     **/
    private $teamHome;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="teamIdAway", referencedColumnName="id")
     **/
    private $teamAway;

    /**
     * @var integer
     *
     * @ORM\Column(name="scoreHome", type="integer", nullable=true)
     */
    private $scoreHome;

    /**
     * @var integer
     *
     * @ORM\Column(name="scoreAway", type="integer", nullable=true)
     */
    private $scoreAway;

    /**
     * @var string
     *
     * @ORM\Column(name="channel", type="string", length=255)
     */
    private $channel;


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
     * Set seasonId
     *
     * @param Season $season
     * @return Game
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get seasonId
     *
     * @return Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set gameDate
     *
     * @param \DateTime $gameDate
     * @return Game
     */
    public function setGameDate($gameDate)
    {
        $this->gameDate = $gameDate;

        return $this;
    }

    /**
     * Get gameDate
     *
     * @return \DateTime 
     */
    public function getGameDate()
    {
        return $this->gameDate;
    }

    /**
     * Set teamHome
     *
     * @param Team $teamHome
     * @return Game
     */
    public function setTeamHome($teamHome)
    {
        $this->teamHome = $teamHome;

        return $this;
    }

    /**
     * Get teamHome
     *
     * @return integer 
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * Set teamAway
     *
     * @param Team $teamAway
     * @return Game
     */
    public function setTeamAway($teamAway)
    {
        $this->teamAway = $teamAway;

        return $this;
    }

    /**
     * Get teamAway
     *
     * @return Team
     */
    public function getTeamAway()
    {
        return $this->teamAway;
    }

    /**
     * Set scoreHome
     *
     * @param integer $scoreHome
     * @return Game
     */
    public function setScoreHome($scoreHome)
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    /**
     * Get scoreHome
     *
     * @return integer 
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * Set scoreAway
     *
     * @param integer $scoreAway
     * @return Game
     */
    public function setScoreAway($scoreAway)
    {
        $this->scoreAway = $scoreAway;

        return $this;
    }

    /**
     * Get scoreAway
     *
     * @return integer 
     */
    public function getScoreAway()
    {
        return $this->scoreAway;
    }

    /**
     * Set channel
     *
     * @param string $channel
     * @return Game
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel
     *
     * @return string 
     */
    public function getChannel()
    {
        return $this->channel;
    }
}
