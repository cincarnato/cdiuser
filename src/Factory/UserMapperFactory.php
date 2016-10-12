<?php

namespace CdiUser\Factory;

/**
 * TITLE
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Form\CreateUser;
use ZfcUser\Form\RegisterFilter;
use ZfcUser\Validator\NoRecordExists;

class UserMapperFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        /** @var $zfcUserOptions \ZfcUser\Options\UserServiceOptionsInterface */
        $zfcUserOptions = $container->get('zfcuser_module_options');
        /** @var $CdiUserOptions \CdiUser\Options\ModuleOptions */
        $cdiUserOptions = $container->get('cdiuser_module_options');

        $mapperClass = $cdiUserOptions->getUserMapper();
        if (stripos($mapperClass, 'doctrine') !== false) {
            $mapper = new $mapperClass(
                    $container->get('zfcuser_doctrine_em'), $zfcUserOptions
            );
        } else {
            $mapper = new $mapperClass();
            $mapper->setDbAdapter($container->get('zfcuser_zend_db_adapter'));
            $entityClass = $zfcUserOptions->getUserEntityClass();
            $mapper->setEntityPrototype(new $entityClass);
            $mapper->setHydrator($container->get('zfcuser_user_hydrator'));
            $mapper->setTableName($zfcUserOptions->getTableName());
        }
        return $mapper;
    }

}
