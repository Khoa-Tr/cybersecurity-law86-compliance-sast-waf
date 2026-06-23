<?php

// VULNERABILITY 5: HARDCODED SECRETS & SENSITIVE DATA IN CODE
return [
    'default' => 'mysql',

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => 'mysql.company.com',
            'database' => 'vulnerable_db',
            'username' => 'root',
            'password' => 'RootPass123!SecureDB', // HARDCODED PASSWORD
        ],
    ],

    'api_keys' => [
        'stripe_secret' => 'sk_live_51234567890abcdef1234567890abcdef',
        'paypal_secret' => 'EIZ5J1Z5DhX-vZZZ_abc123',
        'aws_access_key' => 'AKIAIOSFODNN7EXAMPLE',
        'aws_secret' => 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY',
    ],

    'encryption_keys' => [
        'app_key' => 'base64:abcdefghijklmnopqrstuvwxyz0123456789=',
        'database_key' => 'DBEncrypt987654321',
    ],

    'oauth_jwt' => [
        'jwt_secret' => 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ',
        'oauth_secret' => 'oauth_secret_abc123def456',
    ]
];
