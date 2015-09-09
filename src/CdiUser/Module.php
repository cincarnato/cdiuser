<?php

namespace CdiUser;

class Module {

        public function getConfig() {
        return include __DIR__ . '/../../config/module.config.php';
    } 

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return include __DIR__ . '/../../config/services.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $mvcEvent) {

        ////////////////////////
        //Modifico el form de la administracion
        $app = $mvcEvent->getParam('application');
        $em = $app->getEventManager()->getSharedManager();


        $em->attach('CdiUser\Form\CreateUser', 'init', function($e) {
            // $form is a ZfcUser\Form\Register
            $form = $e->getTarget();

            $sm = $form->getServiceManager();
            $om = $sm->get('Doctrine\ORM\EntityManager');

            #$form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($om, 'Application\Entity\User'));
            $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($om, 'CdiUser\Entity\User'))
                    ->setObject(new \CdiUser\Entity\User());

            $form->add(array(
                'name' => 'roles',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => 'Rol',
                    'object_manager' => $om,
                    'target_class' => 'CdiUser\Entity\Role',
                    'property' => 'roleId'
            )));
        });


        $em->attach('CdiUser\Form\EditUser', 'init', function($e) {
            // $form is a ZfcUser\Form\Register
            $user = $e->getParam('user');
            $form = $e->getTarget();

            $sm = $form->getServiceManager();
            $om = $sm->get('Doctrine\ORM\EntityManager');

            $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($om, 'CdiUser\Entity\User'));

            $form->add(array(
                'name' => 'rol',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => 'Rol',
                    'object_manager' => $om,
                    'target_class' => 'CdiUser\Entity\Role',
                    'property' => 'roleId'
                )
            ));
        });
        
        

       
          //Modifico la registracion para que quede con role "user"
        $zfcServiceEvents = $mvcEvent->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();

        $zfcServiceEvents->attach('register', function($e) use($mvcEvent) {
            $user = $e->getParam('user');
            $em = $mvcEvent->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');

            $defaultUserRole = $em->getRepository('CdiUser\Entity\Role')->find(2);
            $user->setRoles($defaultUserRole);
        });
    }

}
