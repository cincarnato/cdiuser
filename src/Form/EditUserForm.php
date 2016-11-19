<?php

namespace CdiUser\Form;

use ZfcUser\Entity\UserInterface;
use ZfcUser\Form\Register;
use ZfcUser\Options\RegistrationOptionsInterface;
use CdiUser\Options\ModuleOptionsInterface;


class EditUserForm extends Register {

    /**
     * @var \CdiUser\Options\UserEditOptionsInterface
     */
    protected $userEditOptions;
    protected $userEntity;
    protected $serviceManager;

    public function __construct($name = null, RegistrationOptionsInterface $zfcUserOptions, ModuleOptionsInterface $createOptions) {
        $this->setUserEditOptions($createOptions);

        parent::__construct($name, $zfcUserOptions);

        $this->remove('captcha');

        if ($this->getUserEditOptions()->getAllowPasswordChange()) {
//            $this->add(array(
//                'name' => 'reset_password',
//                'type' => 'Zend\Form\Element\Checkbox',
//                'options' => array(
//                    'label' => 'Reset password to random',
//                ),
//            ));

            $password = $this->get('password');
            $password->setAttribute('required', false);
            $password->setOptions(array('label' => 'Password (Solo si se desea cambiar)'));

            $this->remove('passwordVerify');
        } else {
            $this->remove('password')->remove('passwordVerify');
        }

        foreach ($this->getUserEditOptions()->getEditFormElements() as $name => $element) {
            // avoid adding fields twice (e.g. email)
            // if ($this->get($element)) continue;

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

           //STATE
        $this->add(array(
            'name' => 'state',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'required' => false,
                'class' => "form-control",
                
            ),
            'options' => array(
                'label' => 'Activo',
                'description' => '',
            )
        ));
        
          
        //RENAME ESP
        $this->get('username')->setLabel("Usuario");

        $this->get('submit')->setLabel('Save')->setValue('Save');

        $this->add(array(
            'name' => 'userId',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
    }

    public function setUser($userEntity) {
        $this->userEntity = $userEntity;
        $this->getEventManager()->trigger('userSet', $this, array('user' => $userEntity));
    }

    public function getUser() {
        return $this->userEntity;
    }

    public function populateFromUser(UserInterface $user) {
        foreach ($this->getElements() as $element) {
            /** @var $element \Zend\Form\Element */
            $elementName = $element->getName();
            if (strpos($elementName, 'password') === 0)
                continue;

            $getter = $this->getAccessorName($elementName, false);
            if (method_exists($user, $getter))
                $element->setValue(call_user_func(array($user, $getter)));
        }

        foreach ($this->getUserEditOptions()->getEditFormElements() as $element) {
            $getter = $this->getAccessorName($element, false);
            $this->get($element)->setValue(call_user_func(array($user, $getter)));
        }
        $this->get('userId')->setValue($user->getId());
    }

    protected function getAccessorName($property, $set = true) {
        $parts = explode('_', $property);
        array_walk($parts, function (&$val) {
            $val = ucfirst($val);
        });
        return (($set ? 'set' : 'get') . implode('', $parts));
    }

    public function setUserEditOptions(ModuleOptionsInterface $userEditOptions) {
        $this->userEditOptions = $userEditOptions;
        return $this;
    }

    public function getUserEditOptions() {
        return $this->userEditOptions;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

}
