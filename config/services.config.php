<?php

/**
 * User: Vladimir Garvardt
 * Date: 3/18/13
 * Time: 6:39 PM
 */
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Form\RegisterFilter;
use ZfcUser\Mapper\UserHydrator;
use ZfcUser\Validator\NoRecordExists;
use CdiUser\Form;
use CdiUser\Options;
use CdiUser\Validator\NoRecordExistsEdit;

return array(
    'invokables' => array(
        'CdiUser\Form\EditUser' => 'CdiUser\Form\EditUser',
        'zfcuseradmin_user_service' => 'CdiUser\Service\User',
        'cdiuser_doctrine_em' => 'Doctrine\ORM\EntityManager',
    ),
    'factories' => array(
        'cdiuser_options' => function (ServiceLocatorInterface $sm) {
            $config = $sm->get('Config');
            return new Options\CdiUserOptions(isset($config['cdiuser_options']) ? $config['cdiuser_options'] : array());
        },
        'cdiuser_service_user_session' => 'CdiUser\Service\Factory\UserSessionFactory',
        'zfcuseradmin_module_options' => function (ServiceLocatorInterface $sm) {
            $config = $sm->get('Config');
            return new Options\ModuleOptions(isset($config['zfcuseradmin']) ? $config['zfcuseradmin'] : array());
        },
                'zfcuseradmin_edituser_form' => function (ServiceLocatorInterface $sm) {
            /** @var $zfcUserOptions \ZfcUser\Options\UserServiceOptionsInterface */
            $zfcUserOptions = $sm->get('zfcuser_module_options');
            /** @var $zfcUserAdminOptions \CdiUser\Options\ModuleOptions */
            $zfcUserAdminOptions = $sm->get('zfcuseradmin_module_options');
            $form = new Form\EditUser(null, $zfcUserAdminOptions, $zfcUserOptions, $sm);
            $filter = new RegisterFilter(
                    new NoRecordExistsEdit(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'email'
                    )), new NoRecordExistsEdit(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'username'
                    )), $zfcUserOptions
            );
            if (!$zfcUserAdminOptions->getAllowPasswordChange()) {
                $filter->remove('password')->remove('passwordVerify');
            } else {
                $filter->get('password')->setRequired(false);
                $filter->remove('passwordVerify');
            }
            $form->setInputFilter($filter);
            return $form;
        },
                'zfcuseradmin_createuser_form' => function (ServiceLocatorInterface $sm) {
            /** @var $zfcUserOptions \ZfcUser\Options\UserServiceOptionsInterface */
            $zfcUserOptions = $sm->get('zfcuser_module_options');
            /** @var $zfcUserAdminOptions \CdiUser\Options\ModuleOptions */
            $zfcUserAdminOptions = $sm->get('zfcuseradmin_module_options');
            $form = new Form\CreateUser(null, $zfcUserAdminOptions, $zfcUserOptions, $sm);
            $filter = new RegisterFilter(
                    new NoRecordExists(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'email'
                    )), new NoRecordExists(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'username'
                    )), $zfcUserOptions
            );
            if ($zfcUserAdminOptions->getCreateUserAutoPassword()) {
                $filter->remove('password')->remove('passwordVerify');
            }
            $form->setInputFilter($filter);
            return $form;
        },
                'zfcuser_user_mapper' => function (ServiceLocatorInterface $sm) {
            /** @var $config \CdiUser\Options\ModuleOptions */
            $config = $sm->get('zfcuseradmin_module_options');
            $mapperClass = $config->getUserMapper();
            if (stripos($mapperClass, 'doctrine') !== false) {
                $mapper = new $mapperClass(
                        $sm->get('zfcuser_doctrine_em'), $sm->get('zfcuser_module_options')
                );
            } else {
                /** @var $zfcUserOptions \ZfcUser\Options\UserServiceOptionsInterface */
                $zfcUserOptions = $sm->get('zfcuser_module_options');

                /** @var $mapper \CdiUser\Mapper\UserZendDb */
                $mapper = new $mapperClass();
                $mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                $entityClass = $zfcUserOptions->getUserEntityClass();
                $mapper->setEntityPrototype(new $entityClass);
                $mapper->setHydrator($sm->get('zfcuser_user_hydrator'));
                $mapper->setTableName($zfcUserOptions->getTableName());
            }

            return $mapper;
        },
            ),
        );
        
