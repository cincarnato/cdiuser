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

    public function onBootstrap(\Zend\Mvc\MvcEvent $mvcEvent) {

 


        $zfcServiceEvents = $mvcEvent->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register', function($e) use($mvcEvent) {
                    $user = $e->getParam('user');
                    $em = $mvcEvent->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');

                    $defaultUserRole = $em->getRepository('SamUser\Entity\Role')->find(2);
                    $user->setRoles($defaultUserRole);
                });
    }

}