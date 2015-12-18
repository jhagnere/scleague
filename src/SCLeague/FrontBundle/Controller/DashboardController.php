<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 6/22/15
 * Time: 4:32 PM
 */

namespace Self\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DashboardController extends Controller {


    /**
     * @Method({"GET"})
     * @Route("/dashboard")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
} 