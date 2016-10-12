<?php

/**
 * cdiuser Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
return array(
    'cdiuser' => array(
        'user_mapper' => 'CdiUser\Mapper\UserDoctrine',
        'user_list_elements' => array(
            'Id' => 'id',
            'Name' => 'displayName',
            'Email' => 'email',
            'Rol' => 'role',
            'Tel' => 'tel'),
        'create_user_auto_password' => false,
        'create_form_elements' => array(
            'Name' => 'displayName',
        ),
        'edit_form_elements' => array(
            'Name' => 'displayName',
        ),
    ),
);
