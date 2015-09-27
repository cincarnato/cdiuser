<?php

namespace CdiUser\Service\Factory;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of GoogleApiAnalyticsFactory
 *
 * @author cincarnato
 */
class UserSessionFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $options = $serviceLocator->get('cdiuser_options');
        $em = $serviceLocator->get('zfcuser_doctrine_em');
        $userSession = new \CdiUser\Service\UserSession($options, $em, $serviceLocator);
        return $userSession;
    }

}

?>
