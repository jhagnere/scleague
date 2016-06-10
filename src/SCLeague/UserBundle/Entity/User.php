<?php

namespace SCLeague\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Class User
 * @package SCLeague\UserBundle\Entity
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
     * @ORM\Column(name="battle_tag", type="string",length=255, nullable=true)
     * @Assert\NotBlank(message="Please enter your battletag.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The battletag is too short.",
     *     maxMessage="The battletag is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */

    private $battleTag;

    /**
     * @ORM\ManyToOne(targetEntity="SCLeague\TeamBundle\Entity\Team", inversedBy="players")
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

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
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