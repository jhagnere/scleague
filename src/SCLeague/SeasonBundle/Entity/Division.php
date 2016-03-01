<?php

namespace SCLeague\SeasonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Division
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SCLeague\SeasonBundle\Entity\DivisionRepository")
 */
class Division
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="imgDiv", type="string", length=255, nullable=true)
     */
    private $imgDiv;

    /**
     * @ORM\OneToOne(targetEntity="Division")
     * @ORM\JoinColumn(name="nextDiv", referencedColumnName="id", nullable=true)
     **/
    private $nextDivision = null;




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
     * Set name
     *
     * @param string $name
     * @return Division
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set imgDiv
     *
     * @param string $imgDiv
     * @return Division
     */
    public function setImgDiv($imgDiv)
    {
        $this->imgDiv = $imgDiv;

        return $this;
    }

    /**
     * Get imgDiv
     *
     * @return string 
     */
    public function getImgDiv()
    {
        return $this->imgDiv;
    }

    /**
     * @return mixed
     */
    public function getNextDivision()
    {
        return $this->nextDivision;
    }

    /**
     * @param mixed $nextDivision
     */
    public function setNextDivision($nextDivision)
    {
        $this->nextDivision = $nextDivision;
    }

    function __toString()
    {
      return $this->name;
    }

}
