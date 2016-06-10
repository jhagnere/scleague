<?php
namespace SCLeague\FrontBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use SCLeague\FrontBundle\Entity\Post;

class PostManager implements PostManagerInterface
{
    private $posts;

    /**
     * @var EntityManager
     */
    private $entityManager;

    private $postClass;


    /**
     * @param EntityManager $em
     * @param string $postClass
     */
    public function __construct(EntityManager $em, $postClass) {
        $this->entityManager = $em;
        $this->postClass = $postClass;
        $this->posts = new ArrayCollection();

    }

    public function findAll() {

        $entities = $this->entityManager->getRepository($this->postClass)->findAll();

        return array(
            'entities' => $entities,
        );
    }


    /**
     * @param $id
     * @return Post
     */
    public function getPost($id)
    {
        $post = $this->entityManager->getRepository($this->postClass)->find($id);
        return $post;
    }
}