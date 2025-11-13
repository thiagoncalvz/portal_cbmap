<?php

use LdapRecord\Models\OpenLDAP\User as OpenLdapUser;

return [
    'provider' => 'users',
    'passwords' => ['sync' => false],
    'attributes' => [
        'model' => App\Models\User::class, // se for sincronizar futuramente
        'sync'  => [
            'name'  => 'cn',
            'email' => fn($u) => $u->getFirstAttribute('mail') ?? ($u->getFirstAttribute('uid').'@cbm.ap.gov.br'),
            'cpf'   => 'uid',
        ],
        'sync_existing' => ['cpf' => 'uid'],
    ],
    // (opcional) explicitando o identificador LDAP:
    'identifiers' => [
        'ldap'     => 'uid',   // atributo LDAP usado no login
        'database' => 'cpf',   // se um dia usar usuário local
    ],
];
