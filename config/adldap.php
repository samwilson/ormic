<?php

return array(
    'account_suffix' => env('ADLDAP_SUFFIX'),
    'domain_controllers' => array(env('ADLDAP_DC1')), // An array of domains may be provided for load balancing.
    'base_dn' => env('ADLDAP_BASEDN'),
    //'admin_username' => '',
    //'admin_password' => 'password',
    'real_primary_group' => true, // Returns the primary group (an educated guess).
    'use_ssl' => false, // If TLS is true this MUST be false.
    'use_tls' => false, // If SSL is true this MUST be false.
    'recursive_groups' => true,
);
