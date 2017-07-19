<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZfcUser\Mapper\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use CdiUser\Options\ModuleOptions;
use Zend\View\Model\ViewModel;

class UserAdminController extends AbstractActionController {

    /** @var array */
    protected $options;
    protected $userMapper;

    /** @var \CdiUser\Form\CreateUser */
    protected $createUserForm;

    /** @var \CdiUser\Form\EditUser */
    protected $editUserForm;

    /** @var \CdiUser\Service\User */
    protected $adminUserService;

    /** @var array */
    protected $zfcUserOptions;

    /**
     * Description
     * 
     * @var \CdiDataGrid\Grid 
     */
    protected $grid;

    function getGrid() {
        return $this->grid;
    }

    function setGrid(\CdiDataGrid\Grid $grid) {
        $this->grid = $grid;
    }

    public function __construct(\CdiDataGrid\Grid $grid, $createUserForm, $editUserForm, ModuleOptions $options = null, UserInterface $userMapper = null, $adminUserService = null, ZfcUserModuleOptions $zfcUserOptions = null
    ) {
        $this->grid = $grid;
        $this->createUserForm = $createUserForm;
        $this->editUserForm = $editUserForm;
        $this->options = $options;
        $this->userMapper = $userMapper;
        $this->adminUserService = $adminUserService;
        $this->zfcUserOptions = $zfcUserOptions;
    }

    public function listAction() {
       // $this->grid->setTemplate("ajax");
          
          $this->grid->addExtraColumn("Grupos", "<a class='btn btn-primary btn-xs fa fa-users' href='/admin/user/teams/{{id}}' ></a>", "right", false);
      
        $this->grid->prepare();
        
        
        //WAre
        $this->grid->setTableClass("table-condensed text-center");
        $this->grid->getFormFilters()->remove("password");

        $viewModel = new ViewModel(array('grid' => $this->grid));
        return $viewModel;
    }

    public function createAction() {
        /** @var $form \ZfcUserAdmin\Form\CreateUser */
        $form = $this->createUserForm;
        $request = $this->getRequest();
        /** @var $request \Zend\Http\Request */
        if ($request->isPost()) {
            $zfcUserOptions = $this->getZfcUserOptions();
            $class = $zfcUserOptions->getUserEntityClass();
            $user = new $class();
            //$form->setHydrator(new ClassMethods());
            $form->bind($user);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $this->getAdminUserService()->create($form, (array) $request->getPost());
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was created');
                    return $this->redirect()->toRoute('cdiuser_admin/list');
                }
            }
        }
        return array(
            'createUserForm' => $form
        );
    }

    public function editAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        $user = $this->getUserMapper()->findById($userId);
        $form = $this->editUserForm;
        $originalPassword = $user->getPassword();
        // $form->setUser($user);
        $form->bind($user);
        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
        $data = $request->getPost();
   

        if ($request->isPost()) {
            $form->setData($data);
            if ($form->isValid()) {
                $user = $this->getAdminUserService()->edit($form, (array) $request->getPost(), $user, $originalPassword);
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was edited');
                    return $this->redirect()->toRoute('cdiuser_admin/list');
                }
            }
        } else {
            $form->populateFromUser($user);
        }
        return array(
            'editUserForm' => $form,
            'userId' => $userId
        );
    }

    public function removeAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        /** @var $identity \ZfcUser\Entity\UserInterface */
        $identity = $this->zfcUserAuthentication()->getIdentity();
        if ($identity && $identity->getId() == $userId) {
            $this->flashMessenger()->addErrorMessage('You can not delete yourself');
        } else {
            $user = $this->getUserMapper()->findById($userId);
            if ($user) {
                $this->getUserMapper()->remove($user);
                $this->flashMessenger()->addSuccessMessage('The user was deleted');
            }
        }
        return $this->redirect()->toRoute('cdiuser_admin/list');
    }
    
    
    public function sendAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
       $user = $this->getUserMapper()->findById($userId);

        //DO SOMETHING IF FORM IS VALID

        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        $bcrypt->setCost($this->zfcUserOptions->getPasswordCost());
        $newRandomPassword = $this->generateRandomPassword();
        $user->setPassword($bcrypt->create($newRandomPassword));
        $user->setSendAccess(true);

        try {
             $this->getUserMapper()->save($user);
            $this->email($user, $newRandomPassword);
            $this->flashMessenger()->addSuccessMessage('Se envio el mail con exito al usuario: ' . $user->getEmail());
        } catch (Exception $ex) {
            $this->flashMessenger()->addErrorMessage('Error al enviar el acceso al usuario: ' . $user->getEmail());
        }

        return $this->redirect()->toRoute('cdiuser_admin/list');
    }

    protected function generateRandomPassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function email($user, $newRandomPassword) {
        $this->CdiUserMail();
        $this->CdiUserMail()->setTemplate($this->options->getMailTemplatePasswordSend(), ["user" => $user, "newPassword" => $newRandomPassword]);
        $this->CdiUserMail()->setFrom($this->options->getMailFrom(), $this->options->getMailFromName());
        $this->CdiUserMail()->addTo($user->getEmail(), $user->toString());
        $this->CdiUserMail()->setSubject('Acceso al Portal');
        $this->CdiUserMail()->send();
    }

    public function setOptions(ModuleOptions $options) {
        $this->options = $options;
        return $this;
    }

    public function getOptions() {
        return $this->options;
    }

    public function getUserMapper() {
        return $this->userMapper;
    }

    public function setUserMapper(UserInterface $userMapper) {
        $this->userMapper = $userMapper;
        return $this;
    }

    public function getAdminUserService() {
        return $this->adminUserService;
    }

    public function setAdminUserService($service) {
        $this->adminUserService = $service;
        return $this;
    }

    public function setZfcUserOptions(ZfcUserModuleOptions $options) {
        $this->zfcUserOptions = $options;
        return $this;
    }

    /**
     * @return \ZfcUser\Options\ModuleOptions
     */
    public function getZfcUserOptions() {
        return $this->zfcUserOptions;
    }

}
