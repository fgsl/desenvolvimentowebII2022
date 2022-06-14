<?php



return [
    'db' => [
        'driver'   => 'Pdo_Mysql',
        'database' => 'escola',         //'database' é nome do banco de dados 
        'username' => 'root',
        'password' => '',
        'hostname' => 'localhost'

    ],
    'service_manager' => [
        'factories' => [
            'conexao' => Laminas\Db\Adapter\AdapterServiceFactory::class

        ]
    ]
];
