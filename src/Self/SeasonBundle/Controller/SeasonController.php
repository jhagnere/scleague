<?php

namespace Self\SeasonBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Self\SeasonBundle\Entity\Season;
use Self\SeasonBundle\Form\SeasonType;
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
