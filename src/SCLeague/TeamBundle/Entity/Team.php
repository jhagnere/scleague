<?php

namespace SCLeague\TeamBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Team
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SCLeague\TeamBundle\Entity\TeamRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Team
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
     * @ORM\Column(name="websiteUrl", type="string", length=255, nullable=true)
     */
    private $websiteUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="shortname", type="string", length=10)
     */
    private $shortName;

    /**
     * @var Array[User]
     *
     * @ORM\OneToMany(targetEntity="SCLeague\UserBundle\Entity\User", mappedBy="team")
     **/
    private $players;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @param mixed $seasonTeam
     */
    private $temp;

        /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


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
     * @return Team
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
     * Set websiteUrl
     *
     * @param string $websiteUrl
     * @return Team
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * Get websiteUrl
     *
     * @return string 
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Team
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set shortname
     *
     * @param string $shortName
     * @return Team
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortname
     *
     * @return string 
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @return Array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param Array $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
    }

    function __construct() {
        $this->players = new ArrayCollection();
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (is_file($this->getAbsolutePath())) {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
        } else {
            if (null !== $this->getFile()) {
                $fileName = md5(uniqid());
                $this->setPath($fileName.'.'.$this->getFile()->guessExtension());
            }
        }
    }




    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * @return void
     */
    public function upload() {
        if (null === $this->getFile()) {
            return;
        }

        if (null !== $this->getFile() && $this->getPath() == null) {
            $fileName = md5(uniqid());
            $this->setPath($fileName.'.'.$this->getFile()->guessExtension());
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->getPath());
        if(isset($this->temp)) {
            unlink($this->temp);
            $this->temp = null;
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp) && is_file($this->temp)) {
            unlink($this->temp);
        }
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();

    }

    private function getUploadDir()
    {
        return 'uploads/logos';
    }

    private function getAbsolutePath()
    {
        return null === $this->getPath()
            ? null
            : $this->getUploadRootDir().'/'.$this->getPath();
    }

    public function __toString()
    {
        return $this->name;
    }


}
