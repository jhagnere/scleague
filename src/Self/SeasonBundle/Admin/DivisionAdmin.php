<?php

namespace Self\SeasonBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 11/09/15
 * Time: 15:04
 */
class DivisionAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper) {
        $divisionFieldOptions = array();
        $formMapper->add('name', 'text', array('label' => 'Name'))
            ->add('imgDiv', 'file', array('required' => false))
            ->add('nextDivision', 'entity', array('class' => 'Self\SeasonBundle\Entity\Division', 'required' => false, 'placeholder' => 'Choose upper division'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('id')
            ->add('name')
            ->add('nextDivision')

        ;
    }


}