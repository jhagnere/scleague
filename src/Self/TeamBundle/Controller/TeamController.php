<?php

namespace Self\TeamBundle\Controller;

use Self\TeamBundle\Entity\Team;
use Self\TeamBundle\Form\Type\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{
    /*/**
     * @Route("/{name}")
     * @Template()
     */
    /*
    public function displayOneAction($name)
    {
        $team = $this->getDoctrine()->getRepository('Self\TeamBundle\Entity\Team')->findByName($name);
        if ($team instanceof Team) {
            return array('team' => $name);
        } else {
            throw $this->createNotFoundException('This team does not exist');
        }
    }*/

    /**
     * @Route("/")
     * @Template()
     */
    public function listAction() {
        $teams = $this->getDoctrine()->getRepository('Self\TeamBundle\Entity\Team')->findAll();
        return array('teams' => $teams);
    }

    /**
     * @Route("/myteam")
     * @Template()
     */
    public function myTeamAction() {
        $user = $this->getUser();
        $team = $user->getTeam();
        if ($team == null) {
            $response = $this->forward('SelfTeamBundle:Team:new');
            return $response;
        }
        return array('team' => $team);
    }

    /**
     * @Route("/new")
     * @Template()
     * @return array
     */
    public function newAction(Request $request) {
        $team = new Team();

        $form = $this->createForm(new TeamType(), $team);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $em->persist($team);
            $em->flush();

            $user->setTeam($team);
            $em->persist($user);
            $em->flush();


            $this->get('session')->getFlashBag()->add(
                'notice',
                'Team created !'
            );

            return $this->redirect($this->generateUrl('self_front_dashboard_index'));
        }


        return(array('teamForm' => $form->createView()));
    }

}
