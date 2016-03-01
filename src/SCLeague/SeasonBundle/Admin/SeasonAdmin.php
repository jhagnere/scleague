<?php

namespace SCLeague\SeasonBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 11/09/15
 * Time: 15:04
 */
class SeasonAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('name', 'text', array('label' => 'Name'))
            ->add('startDate', 'datetime')
            ->add('endDate', 'datetime')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('name')
            ->add('startDate')
            ->add('endDate')
            ->add('active')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'close' => array('template' => 'SCLeagueSeasonBundle:CRUD:list__action_close.html.twig'),
                    'launch' => array('template' => 'SCLeagueSeasonBundle:CRUD:list__action_launch.html.twig'),
                )
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('launch', $this->getRouterIdParameter().'/launch');
        $collection->add('close', $this->getRouterIdParameter().'/close');
    }


}