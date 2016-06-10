<?php

namespace SCLeague\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SCLeague\FrontBundle\Entity\PostRepository")
 */
class Post
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="authorBy", type="string", length=255)
     */
    private $authorBy;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="createdDate", type="datetime", length=255)
     */
    private $createdDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isNews", type="boolean")
     */
    private $isNews;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
    private $comments;


    public function __construct()
    {
        $this->createdDate = new \DateTime();
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
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set authorBy
     *
     * @param string $authorBy
     * @return Post
     */
    public function setAuthorBy($authorBy)
    {
        $this->authorBy = $authorBy;

        return $this;
    }

    /**
     * Get authorBy
     *
     * @return string 
     */
    public function getAuthorBy()
    {
        return $this->authorBy;
    }

    /**
     * Set createdDate
     *
     * @param \Datetime $createdDate
     * @return Post
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \Datetime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set isNews
     *
     * @param boolean $isNews
     * @return Post
     */
    public function setIsNews($isNews)
    {
        $this->isNews = $isNews;

        return $this;
    }

    /**
     * Get isNews
     *
     * @return boolean 
     */
    public function getIsNews()
    {
        return $this->isNews;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Post
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
