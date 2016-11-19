<?php

namespace CdiUser\Form;

use Zend\Form\Form;

class LostPasswordForm extends Form {

    public function __construct() {
        parent::__construct('LostPassword');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form-horizontal");
        $this->setAttribute('role', "form");
        
        
        //PUT YOUR ELEMENTS
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'required' => false,
                'class' => 'form-control',
                'placeholder' => 'Email'
            ),
            'options' => array(
                'label' => '',
                'description' => 'Ingrese el email registrado'
            )
        ));
        
        //BASE
        
        
        //$this->addCsrf(); //Optional security
        
        $this->addSubmit("Enviar");
        
    }

    protected function addSubmit($value = "submit") {

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => $value,
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
