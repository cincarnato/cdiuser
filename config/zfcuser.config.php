<?php

return array(
    'user_entity_class' => 'CdiUser\Entity\User',
    'enable_default_entities' => false,
    'enable_registration' => true,
    'enable_username' => true,
    'auth_identity_fields' => array('email', 'username'),
    'login_after_registration' => true,
    'use_redirect_parameter_if_present' => true,
);
