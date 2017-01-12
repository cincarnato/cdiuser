<?php

namespace CdiUser\Form;

use Zend\Form\Form;

class GroupUsers extends Form {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        parent::__construct('GroupUsers');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form-horizontal");
        $this->setAttribute('role', "form");

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'users',
            'options' => array(
                'object_manager' => $this->em,
                'target_class' => 'CdiUser\Entity\User'
            )
        ));

        $this->addSubmit();
    }

    protected function addSubmit() {

        $this->add(array(
            'name' => 'submitbtn',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Guardar",
                'class' => 'btn btn-primary'
            )
        ));
    }

    protected function addCsrf() {
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));
    }

}
