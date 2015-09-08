<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcUser\Mapper\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use CdiUser\Options\ModuleOptions;

class UserAdminController extends AbstractActionController {

    protected $options, $userMapper;
    protected $zfcUserOptions;

    /**
     * @var \CdiUser\Service\User
     */
    protected $adminUserService;


    //TEMPORAL

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function listAction() {
        $userMapper = $this->getUserMapper();
        $users = $userMapper->findAll();
        if (is_array($users)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($users));
        } else {
            $paginator = $users;
        }

        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));
        return array(
            'users' => $paginator,
            'userlistElements' => $this->getOptions()->getUserListElements()
        );
    }

    public function createAction() {
        /** @var $form \CdiUser\Form\CreateUser */
        $form = $this->getServiceLocator()->get('zfcuseradmin_createuser_form');
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
                //var_dump($user);
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was created');
                    return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
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

        /** @var $form \CdiUser\Form\EditUser */
        $form = $this->getServiceLocator()->get('zfcuseradmin_edituser_form');
        $form->setUser($user);
        
        //Si se pone el bind, levanta la password en el form y es un problema
        //$form->bind($user);
      

        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

            
                //Provisiorio. Se debe mover. (Parche)     
                $role = $this->getEntityManager()->find("CdiUser\Entity\Role", $this->params()->fromPost('rol'));
               $user->setRoles($role);

                $user = $this->getAdminUserService()->edit($form, (array) $request->getPost(), $user);

                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was edited');
                      return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
                }
            }
        } else {
        
            $form->populateFromUser($user);
            //Parche para mostrar el rol adeacuado
            $form->get('rol')->setValue($user->getRoles()->getId());
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

        return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
    }

    public function roleAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        $user = $this->getUserMapper()->findById($userId);

        $form = $this->getServiceLocator()->get('zfcuseradmin_roleuser_form');
        $form->setUser($user);


        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                //Aca debo persistir
                $user = $this->getAdminUserService()->edit($form, (array) $request->getPost(), $user);

                //Si persiste ok
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user role was edited');
                    return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
                }
            }
        } else {
            $form->populateFromUser($user);
        }

        return array(
            'roleUserForm' => $form,
            'userId' => $userId
        );
    }

    public function setOptions(ModuleOptions $options) {
        $this->options = $options;
        return $this;
    }

    public function getOptions() {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('zfcuseradmin_module_options'));
        }
        return $this->options;
    }

    public function getUserMapper() {
        if (null === $this->userMapper) {
            $this->userMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        }
        return $this->userMapper;
    }

    public function setUserMapper(UserInterface $userMapper) {
        $this->userMapper = $userMapper;
        return $this;
    }

    public function getAdminUserService() {
        if (null === $this->adminUserService) {
            $this->adminUserService = $this->getServiceLocator()->get('zfcuseradmin_user_service');
        }
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
        if (!$this->zfcUserOptions instanceof ZfcUserModuleOptions) {
            $this->setZfcUserOptions($this->getServiceLocator()->get('zfcuser_module_options'));
        }
        return $this->zfcUserOptions;
    }

}
