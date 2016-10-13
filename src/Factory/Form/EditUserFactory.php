<?php

namespace CdiUser\Factory\Form;

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
use CdiUser\Form\EditUserForm;
use ZfcUser\Form\RegisterFilter;
use CdiUser\Validator\NoRecordExistsEdit;

class EditUserFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        /** @var $zfcUserOptions \ZfcUser\Options\UserServiceOptionsInterface */
        $zfcUserOptions = $container->get('zfcuser_module_options');
        /** @var $CdiUserOptions \CdiUser\Options\ModuleOptions */
        $cdiUserOptions = $container->get('cdiuser_module_options');
         

        $form = new EditUserForm("EditUser", $zfcUserOptions, $cdiUserOptions);


       //Defino el hidrator doctrine y agrego object select para role
        $om = $container->get('doctrine.entitymanager.orm_default');
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($om, 'CdiUser\Entity\User'));
        $form->add(array(
            'name' => 'role',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Role',
                'object_manager' => $om,
                'target_class' => 'CdiUser\Entity\Role',
                'property' => 'name'
        )));

        //Filtro para evitar repetidos
        $filter = new RegisterFilter(
                new NoRecordExistsEdit(array(
            'mapper' => $container->get('zfcuser_user_mapper'),
            'key' => 'email'
                )), new NoRecordExistsEdit(array(
            'mapper' => $container->get('zfcuser_user_mapper'),
            'key' => 'username'
                )), $zfcUserOptions
        );

        //Verifico si autogenero la password
        if (!$cdiUserOptions->getAllowPasswordChange()) {
            $filter->remove('password')->remove('passwordVerify');
        } else {
            $filter->get('password')->setRequired(false);
            $filter->remove('passwordVerify');
        }
        $form->setInputFilter($filter);
        return $form;
    }

}
