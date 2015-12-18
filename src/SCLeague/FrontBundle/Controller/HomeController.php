<?php

namespace Self\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class HomeController
 * @package SCLeague\FrontBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
