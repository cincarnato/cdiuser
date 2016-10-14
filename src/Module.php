<?php

namespace CdiUser;

class Module {

    public function getControllerConfig() {
        return include __DIR__ . '/../config/controller.config.php';
    }

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
        return include __DIR__ . '/../config/services.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $mvcEvent) {
        
        //RBAC
//        $t = $mvcEvent->getTarget();
//        $t->getEventManager()->attach(
//                $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy')
//        );
        
        //Asigno un Rol al usuario que se registra
        $zfcServiceEvents = $mvcEvent->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register', function($e) use($mvcEvent) {
            $user = $e->getParam('user');
            $em = $mvcEvent->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');

            $defaultUserRole = $em->getRepository('CdiUser\Entity\Role')->find(2);
            $user->setRoles($defaultUserRole);
        });
    }

}
