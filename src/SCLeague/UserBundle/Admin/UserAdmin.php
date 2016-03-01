<?php

namespace SCLeague\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('username', 'text')
            ->add('email', 'text')
            ->add('battleTag', 'text', array('label' => 'BattleTag'))
            ->add('team', 'entity', array('class' => 'SCLeague\TeamBundle\Entity\Team', 'label' => 'Team', 'placeholder' => 'Choose your Team'))

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('username')
            ->add('email')
            ->add('battleTag')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('battleTag')
            ->add('team')
            ->add('enabled', null, array('editable' => true))
            ->add('locked', null, array('editable' => true))
             ;
        ;
    }

}