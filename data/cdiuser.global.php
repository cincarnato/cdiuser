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
        'allow_password_change' => true,
        'create_user_auto_password' => false,
        "mail" => [
            "message" => [
                "web" => "",
                "fromMail" => "info@perfilit.com.ar",
                "fromName" => "LP"
            ],
            "transport" => [
                "type" => "sendmail",
                "smtp" => "127.0.0.1",
            ]
        ]
    ),
    'zfcuser' => array(
        'user_entity_class' => 'CdiUser\Entity\User',
        'enable_default_entities' => false,
        'enable_registration' => true,
        'enable_username' => true,
        'enable_user_state' => true,
        'default_user_state' => true,
        'allowed_login_states' => [true],
        'auth_identity_fields' => array('email', 'username'),
        'login_after_registration' => true,
        'use_redirect_parameter_if_present' => true,
    )
);
