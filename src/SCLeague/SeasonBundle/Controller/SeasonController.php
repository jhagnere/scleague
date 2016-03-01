<?php

namespace SCLeague\SeasonBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SCLeague\SeasonBundle\Entity\Season;
use SCLeague\SeasonBundle\Form\SeasonType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Season controller.
 */
class SeasonController extends CRUDController
{

    public function launchAction($id) {
       /**
        * Close active season & launch new one
        *
        * Trigger up & down for team
        *
        */

        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $seasonLaunch =  $this->container->get('scleague_season.season.manager')->launchSeason($id);

        return 'test';
    }

    public function closeAction() {
        /**
         * Close active season & launch new one
         *
         * Trigger up & down for team
         *
         */


    }


}
