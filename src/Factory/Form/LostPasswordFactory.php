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
use CdiUser\Form\LostPasswordForm;
use CdiUser\InputFilter\LostPasswordFilter;
use CdiUser\Validator\RecordExistsEmail;

class LostPasswordFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $form = new LostPasswordForm();

        //Filtro para evitar repetidos
        $filter = new LostPasswordFilter(
                new RecordExistsEmail(["mapper" =>$container->get('zfcuser_user_mapper')])
                );

        $form->setInputFilter($filter);
        return $form;
    }

}
