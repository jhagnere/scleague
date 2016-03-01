<?php

namespace SCLeague\TeamBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TeamAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('name', 'text', array('label' => 'Name'))
        ->add('shortName', 'text')
        ->add('websiteUrl', 'text', array('required' => false, 'label' => 'Website'))
        ->add('file', 'file', array('required' => false, 'label' => 'logo'))
        ->add('players', 'entity', array('required' => false, 'class' => 'SCLeague\UserBundle\Entity\User'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
            ->add('shortName')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('name')
            ->add('shortName')
            ->add('websiteUrl')
        ;
    }

}