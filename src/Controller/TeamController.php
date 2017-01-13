<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail;
use Zend\Crypt\Password\Bcrypt;

class TeamController extends AbstractActionController {

    /** @var array */
    protected $moduleOptions;

    /** @var array */
    protected $zfcUserOptions;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Description
     * 
     * @var \CdiDataGrid\Grid 
     */
    protected $grid;

    function getEm() {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function getLpForm() {
        return $this->lpForm;
    }

    function setLpForm(\CdiUser\Form\LostPasswordForm $lpForm) {
        $this->lpForm = $lpForm;
    }

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid, $moduleOptions) {
        $this->em = $em;
        $this->moduleOptions = $moduleOptions;
        $this->grid = $grid;
    }

    public function listAction() {
        
          $this->grid->addExtraColumn("Usuarios", "<a class='btn btn-primary btn-xs fa fa-user' href='/admin/team/users/{{id}}' ></a>", "right", false);
      
        $this->grid->prepare();
        
        // $this->grid->getFormFilters()->remove("users");

        return array("grid" => $this->grid);
    }

}
