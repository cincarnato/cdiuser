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

    public function onBootstrap(EventInterface $mvc_event) {


        //ServiceManager,EventManager,SharedEventManager
        $sm = $mvc_event->getApplication()->getServiceManager();
        $eventManager = $mvc_event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        //RBAC-STRATEGY (TO IMPROVE)
//        $t = $mvc_event->getTarget();
//        $ListenerAggregate = $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy');

        $ListenerAggregate = $sm->get('ZfcRbac\View\Strategy\RedirectStrategy');
        $ListenerAggregate->attach($eventManager);

        //RBAC-NAVIGATION
        $rbacListener = $sm->get('CdiUser\Listener\RbacListener');
        $sharedEventManager->attach(
                'Zend\View\Helper\Navigation\AbstractHelper', 'isAllowed', array($rbacListener, 'accept')
        );



        //Asigno un Rol al usuario que se registra
        $zfcService = $sm->get('zfcuser_user_service');
        $zfcServiceEvents = $zfcService->getEventManager();
        $zfcServiceEvents->attach('register', function($zfc_event) use ($sm) {
            $user = $zfc_event->getParam('user');
            $em = $sm->get('doctrine.entitymanager.orm_default');
            $defaultUserRole = $em->getRepository('CdiUser\Entity\Role')->find(2);
            $user->setRole($defaultUserRole);
        });


        //USR-LOG: 
        //Debo generar estos eventos dependiendo de las opciones cdiuser-log = true|false
        $zfcAuthEvents = $mvc_event->getApplication()->getServiceManager()->get('ZfcUser\Authentication\Adapter\AdapterChain')->getEventManager();
        $zfcAuthEvents->attach('authenticate.success'
                , function($e) use($sm) {

            $userId = $e->getTarget()->getIdentity();

            /* @var $em \Doctrine\ORM\EntityManager */
            $em = $sm->get('doctrine.entitymanager.orm_default');
            /* @var $em \CdiEntity\Entity\User */
            $user = $em->getRepository('CdiUser\Entity\User')->find($userId);
            /* @var $userLog \CdiEntity\Entity\UserLog */
            $userLog = $em->getRepository('CdiUser\Entity\UserLog')->findByUser($user);


            //DATA
            $remote = new \Zend\Http\PhpEnvironment\RemoteAddress;
            $ip = $remote->setUseProxy()->getIpAddress();
            $sesionId = session_id();
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $now = new \DateTime("now");
            if (!$userLog) {
                $userLog = new \CdiUser\Entity\UserLog();
                $userLog->setUser($user);
                $userLog->setFirstIp($ip);
            }
            $userLog->setLastSesion($now);
            $userLog->setLastIp($ip);
            $userLog->setSesionId($sesionId);
            $userLog->setLoginCount($userLog->getLoginCount() + 1);
            $userLog->setAgent($agent);
            $em->getRepository('CdiUser\Entity\UserLog')->save($userLog);

            //LOG DETAIL
            $userLogDetail = new \CdiUser\Entity\UserLogDetail();
            $userLogDetail->setUser($user);
            $userLogDetail->setIp($ip);
            $userLogDetail->setDateSesion($now);
            $userLogDetail->setAgent($agent);
            $userLogDetail->setSesionId($sesionId);
            $em->getRepository('CdiUser\Entity\UserLogDetail')->save($userLogDetail);
        }
        );
    }

}
