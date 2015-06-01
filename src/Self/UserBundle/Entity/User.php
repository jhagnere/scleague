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

    public function __construct() {
        parent::__construct();
    }


} 