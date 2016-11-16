<?php

namespace CdiUser;

use Zend\EventManager\EventInterface;

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

    public function onBootstrap(EventInterface $e) {

        //RBAC-STRATEGY (TO IMPROVE)
        $t = $e->getTarget();
        $ListenerAggregate = $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy');
        $ListenerAggregate->attach($t->getEventManager());

        //RBAC-NAVIGATION
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $serviceManager = $application->getServiceManager();
        $rbacListener = $serviceManager->get('CdiUser\Listener\RbacListener');

        $sharedEventManager->attach(
                'Zend\View\Helper\Navigation\AbstractHelper', 'isAllowed', array($rbacListener, 'accept')
        );



        //Asigno un Rol al usuario que se registra
        $zfcServiceEvents = $e->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register', function($e) use($e) {
            $user = $e->getParam('user');
            $em = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');

            $defaultUserRole = $em->getRepository('CdiUser\Entity\Role')->find(2);
            $user->setRoles($defaultUserRole);
        });
    }

}
