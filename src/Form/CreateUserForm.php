<?php

namespace CdiUser\Form;

use CdiUser\Options\ModuleOptionsInterface;
use ZfcUser\Options\RegistrationOptionsInterface;
use ZfcUser\Form\Register as Register;

class CreateUserForm extends Register {

    /**
     * @var ModuleOptionsInterface
     */
    protected $createOptions;

    public function __construct($name = null, RegistrationOptionsInterface $zfcUserOptions, ModuleOptionsInterface $createOptions) {
        $this->setCreateOptions($createOptions);
        parent::__construct($name, $zfcUserOptions);

        foreach ($this->getCreateOptions()->getCreateFormElements() as $name => $element) {
            // avoid adding fields twice (e.g. email)
            if ($this->get($element))
                continue;
            $this->add(array(
                'name' => $element,
                'options' => array(
                    'label' => $name,
                ),
                'attributes' => array(
                    'type' => 'text'
                ),
            ));
        }
        
        //RENAME ESP
        $this->get('username')->setLabel("Usuario");

        //STATE
        $this->add(array(
            'name' => 'state',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'required' => false,
                'class' => "form-control",
                 'checked' => 'checked',
            ),
            'options' => array(
                'label' => 'Activo',
                'description' => '',
            )
        ));

        $this->get('submit')->setAttribute('label', 'Create');
    }

    public function setCreateOptions(ModuleOptionsInterface $createOptions) {
        $this->createOptions = $createOptions;
        return $this;
    }

    public function getCreateOptions() {
        return $this->createOptions;
    }

}
