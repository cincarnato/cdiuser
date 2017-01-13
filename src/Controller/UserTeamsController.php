<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class UserTeamsController extends AbstractActionController {

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
     * @var \CdiUser\Entity\User
     */
    protected $user;

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

    function setForm(\CdiUser\Form\UserTeams $form) {
        $this->form = $form;
    }

    function getUser() {
        return $this->user;
    }

    function setUser(\CdiUser\Entity\User $user) {
        $this->user = $user;
    }

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiUser\Form\UserTeams $form, \CdiUser\Entity\User $user, $moduleOptions) {
        $this->em = $em;
        $this->moduleOptions = $moduleOptions;
        $this->form = $form;
        $this->user = $user;
    }

    public function teamsAction() {
        $this->form->bind($this->user);
        $this->form->getInputFilter()->get('teams')->setRequired(false);
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $this->form->setData($data);

            if ($this->form->isValid()) {

                if ($this->getRequest()->getPost('teams') === null) {
                    $this->user->setTeams(null); // set null to remove all associations with this client
                }

                try {

                    $this->getEm()->getRepository("\CdiUser\Entity\User")->save($this->user);
                    $this->flashMessenger()->addSuccessMessage('Grupos Guardados en usuario: ' . $this->user->getUsername() . '');
                    $this->redirect()->toRoute("cdiuser_admin/list");
                } catch (\Exception $ex) {
                    $this->flashMessenger()->addErrorMessage('Falla al guardar grupos en usuario: ' . $this->user->getUsername() . '');
                    $this->redirect()->toRoute("cdiuser_admin/list");
                }
            }
        }

        return array('form' => $this->form, 'user' => $this->user);
    }

}
