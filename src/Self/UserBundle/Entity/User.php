<?php

namespace Self\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;



/**
 * Class User
 * @package Self\UserBundle\Entity
 * @ORM\Entity
 * @ORM\Table("sl_user")
 */
class User extends BaseUser {


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="battle_tag", type="string",length=255)
     */
    private $battleTag;

    /**
     * @ORM\ManyToOne(targetEntity="Self\TeamBundle\Entity\Team", inversedBy="players")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     **/
    private $team;

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    public function __construct() {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getBattleTag()
    {
        return $this->battleTag;
    }

    /**
     * @param mixed $battleTag
     */
    public function setBattleTag($battleTag)
    {
        $this->battleTag = $battleTag;
    }


} 