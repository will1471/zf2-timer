<?php


return array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Login',
                        'action'     => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Login',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'create-account' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/create-account',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Account',
                        'action'     => 'create',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Account' => 'Auth\Controller\AccountController',
            'Auth\Controller\Login' => 'Auth\Controller\LoginController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
