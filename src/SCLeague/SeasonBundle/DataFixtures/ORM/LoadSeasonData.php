<?php

namespace Self\SeasonBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Proxies\__CG__\Self\SeasonBundle\Entity\Season;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSeasonData implements FixtureInterface, ContainerAwareInterface
{

    private $container;
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $season = new Season();
        $season->setStartDate(new DateTime('NOW'));
        $season->setEndDate(new DateTime('NOW + 2 months'));
        $season->setName('Season Test');
        $season->setActive(true);
        $manager->persist($season);
        $manager->flush();
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}