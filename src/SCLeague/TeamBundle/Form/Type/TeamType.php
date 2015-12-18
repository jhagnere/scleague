<?php

namespace Self\TeamBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 6/22/15
 * Time: 6:51 PM
 */

class TeamType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('name', 'text');
        $builder->add('shortName', 'text');
        $builder->add('websiteUrl', 'text', array('required' => false, 'label' => 'Website'));
        $builder->add('file', 'file', array('required' => false, 'label' => 'logo'));
        $builder->add('save', 'submit', array('label' => 'Create Team'));
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'team';
    }


}