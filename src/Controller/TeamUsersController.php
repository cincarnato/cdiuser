<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class TeamUsersController extends AbstractActionController {

    /** @var array */
    protected $moduleOptions;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \CdiUser\Form\TeamUsers
     */
    protected $form;

    /**
     * @var \CdiUser\Entity\Team
     */
    protected $team;

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

    function setForm(\CdiUser\Form\TeamUsers $form) {
        $this->form = $form;
    }

    function getTeam() {
        return $this->team;
    }

    function setTeam(\CdiUser\Entity\Team $team) {
        $this->team = $team;
    }

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiUser\Form\TeamUsers $form, \CdiUser\Entity\Team $team, $moduleOptions) {
        $this->em = $em;
        $this->moduleOptions = $moduleOptions;
        $this->form = $form;
        $this->team = $team;
    }

    public function usersAction() {
        $this->form->bind($this->team);
         $this->form->getInputFilter()->get('users')->setRequired(false);
       
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $this->form->setData($data);

            if ($this->form->isValid()) {
                var_dump($this->getRequest()->getPost('users'));
                if ($this->getRequest()->getPost('users') === null) {
                     /* @var $user \CdiUser\Entity\User */
                    foreach($this->team->getUsers() as $user){
                        $user->removeTeam($this->team);
                    }
                     $this->form->get('users')->setValue(null);
                }

                try {
                    $this->getEm()->getRepository("\CdiUser\Entity\Team")->save($this->team);
                   
                    $this->flashMessenger()->addSuccessMessage('Usuarios Guardados en grupo: ' . $this->team->getName() . '');
                    $this->redirect()->toRoute("cdiuser_admin_teams/list");
                } catch (\Exception $ex) {
                    $this->flashMessenger()->addErrorMessage('Falla al guardar usuarios en grupo: ' . $this->team->getName() . '');
                    $this->redirect()->toRoute("cdiuser_admin/list");
                }
            }
        }

        return array('form' => $this->form, 'team' => $this->team);
    }

}
