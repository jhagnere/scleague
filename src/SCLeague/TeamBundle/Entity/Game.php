<?php

namespace Self\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table()
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
    private $seasonId;

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
    private $teamIdHome;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="teamIdAway", referencedColumnName="id")
     **/
    private $teamIdAway;

    /**
     * @var integer
     *
     * @ORM\Column(name="scoreHome", type="integer")
     */
    private $scoreHome;

    /**
     * @var integer
     *
     * @ORM\Column(name="scoreAway", type="integer")
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
     * @param integer $seasonId
     * @return Game
     */
    public function setSeasonId($seasonId)
    {
        $this->seasonId = $seasonId;

        return $this;
    }

    /**
     * Get seasonId
     *
     * @return integer 
     */
    public function getSeasonId()
    {
        return $this->seasonId;
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
     * Set teamIdHome
     *
     * @param integer $teamIdHome
     * @return Game
     */
    public function setTeamIdHome($teamIdHome)
    {
        $this->teamIdHome = $teamIdHome;

        return $this;
    }

    /**
     * Get teamIdHome
     *
     * @return integer 
     */
    public function getTeamIdHome()
    {
        return $this->teamIdHome;
    }

    /**
     * Set teamIdAway
     *
     * @param integer $teamIdAway
     * @return Game
     */
    public function setTeamIdAway($teamIdAway)
    {
        $this->teamIdAway = $teamIdAway;

        return $this;
    }

    /**
     * Get teamIdAway
     *
     * @return integer 
     */
    public function getTeamIdAway()
    {
        return $this->teamIdAway;
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
