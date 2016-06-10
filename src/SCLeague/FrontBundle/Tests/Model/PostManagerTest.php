<?php

namespace SCLeague\FrontBundle\Tests\Model;
use PHPUnit_Framework_TestCase;
use SCLeague\FrontBundle\Entity\Post;
use SCLeague\FrontBundle\Model\PostManager;
use SCLeague\FrontBundle\Tests\Entity\DummyPost;
use Symfony\Component\PropertyInfo\Tests\Fixtures\Dummy;


/**
 * @coversDefaultClass \SCLeague\FrontBundle\Model\PostManager
 */
class PostManagerTest extends PHPUnit_Framework_TestCase
{
    const POST_CLASS = 'SCLeague\FrontBundle\Tests\Entity\DummyPost';


    /**
     * @var PostManager
     */
    protected $postManager;


    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    protected $entityManager;

    public function setUp() {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run');
        }
        $this->getEmMock();
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->postManager = $this->createPostManager();
    }


    /**
     * @test
     * @covers ::getPost
     */
    public function it_should_return_a_post() {
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::POST_CLASS))
            ->will($this->returnValue($this->repository));

        $post = $this->getPost();
        $this->repository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($post));
        $id=1;
        $postObject = $this->postManager->getPost($id);

        $this->assertEquals($post, $postObject);
    }

    /**
     * @return PostManager
     */
    private function createPostManager()
    {
        return new PostManager($this->entityManager, static::POST_CLASS);
    }

    private function getPost()
    {
        $postClass = static::POST_CLASS;
        return new $postClass();
    }

    protected function getEmMock()
    {
        $this->entityManager  = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'persist', 'flush', 'find'), array(), '', false);
    }


}