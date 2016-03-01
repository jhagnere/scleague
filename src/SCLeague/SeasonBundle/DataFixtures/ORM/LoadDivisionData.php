<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/09/15
 * Time: 00:00
 */

namespace SCLeague\SeasonBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SCLeague\SeasonBundle\Entity\Division;

class LoadDivisionData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $division = new Division();
        $division->setName('Division 1');

        $division2 = new Division();
        $division2->setName('Division 2');
        $division->setNextDivision($division);

        $manager->persist($division);
        $manager->persist($division2);
        $manager->flush();
    }
}
