<?php

namespace Self\TeamBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GameAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('seasonId', 'entity', array('class' => 'Self\SeasonBundle\Entity\Season'))
            ->add('gameDate', 'datetime')
            ->add('scoreHome', 'text')
            ->add('scoreAway', 'text')
            ->add('channel', 'text')
            ->add('teamIdHome', 'entity', array('class' => 'Self\TeamBundle\Entity\Team'))
            ->add('teamIdAway', 'entity', array('class' => 'Self\TeamBundle\Entity\Team'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('gameDate')
            ->add('teamIdHome')
            ->add('teamIdAway')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('id')
            ->add('seasonId')
            ->add('gameDate')
            ->add('teamIdHome')
            ->add('scoreHome')
            ->add('scoreAway')
            ->add('teamIdAway')
        ;
    }

}