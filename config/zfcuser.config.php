<?php

return array(
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
    'login_redirect_route' => "cdiuser_log_in",
    'logout_redirect_route' => "cdiuser_log_out",
);
