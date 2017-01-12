<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail;
use Zend\Crypt\Password\Bcrypt;

class GroupUsersController extends AbstractActionController {

    /** @var array */
    protected $moduleOptions;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
     /**
     * @var \CdiUser\Form\GroupUsers
     */
    protected $form;

    function getEm() {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    function getModuleOptions() {
        return $this->moduleOptions;
    }

    function getForm() {
        return $this->form;
    }

    function setModuleOptions($moduleOptions) {
        $this->moduleOptions = $moduleOptions;
    }

    function setForm(\CdiUser\Form\GroupUsers $form) {
        $this->form = $form;
    }

        
    function __construct(\Doctrine\ORM\EntityManager $em, \CdiUser\Form\GroupUsers $form, $moduleOptions) {
        $this->em = $em;
        $this->moduleOptions = $moduleOptions;
        $this->form = $form;
    }

    public function usersAction() {

        $viewModel = new ViewModel(array('form' => $this->form));
        return $viewModel;
    }

}
