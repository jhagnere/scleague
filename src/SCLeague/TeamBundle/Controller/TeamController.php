<?php

namespace SCLeague\TeamBundle\Controller;

use SCLeague\TeamBundle\Entity\Team;
use SCLeague\TeamBundle\Form\Type\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
        $team = $this->getDoctrine()->getRepository('SCLeague\TeamBundle\Entity\Team')->findByName($name);
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
        $teams = $this->getDoctrine()->getRepository('SCLeague\TeamBundle\Entity\Team')->findAll();
        return array('teams' => $teams);
    }

    /**
     * @Route("/{id}", requirements={
     *  "id": "\d+"
     * })
     * @Template()
     */
    public function viewAction($id) {
        $team = $this->getDoctrine()->getRepository('SCLeague\TeamBundle\Entity\Team')->find($id);
        return array('team' => $team);
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
            $form->upload();
            exit;
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

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $teamFromDB = $em->getRepository('SCLeague\TeamBundle\Entity\Team')->find($id);

        if (!$teamFromDB) {
            throw $this->createNotFoundException('No team found for id ' . $id);
        }


        $form = $this->createForm(new TeamType(), $teamFromDB);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $teamFromDB->upload();
            $em->flush();



            return $this->redirect($this->generateUrl('self_team_team_myteam'));
        }


        return(array('teamForm' => $form->createView()));
    }

    /**
     * @Route("/delete")
     * @Method("POST")
     */
   /* public function deleteAction(Request $request) {

        $form = $this->createDeleteForm2($request->request->get('id'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SelfTeamBundle:Team')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Team entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('self_team_team_myteam'));


    } */




}
