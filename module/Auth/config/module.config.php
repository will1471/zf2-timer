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
            'Auth\Controller\Console' => 'Auth\Controller\ConsoleController',
            'Auth\Controller\Login' => 'Auth\Controller\LoginController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                 'console-create-user' => array(
                    'options' => array(
                        'route' => 'user create <email> <password>',
                        'defaults' => array(
                            'controller' => 'Auth\Controller\Console',
                            'action' => 'create',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'auth_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Auth/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Auth\Entity' => 'auth_entities'
                ),
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Auth\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function(\Auth\Entity\User $user, $passwordGiven) {
                    return password_verify($passwordGiven, $user->getPassword());
                },
            ),
        ),
    ),
);
