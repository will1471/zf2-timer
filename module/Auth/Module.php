<?php

namespace Auth;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'authentication-service' => function($sm) {
                    return $sm->get('doctrine.authenticationservice.orm_default');
                },

                'user-service' => function($sm) {
                    return new UserService($sm->get('Doctrine\ORM\EntityManager'));
                },

            ),
        );
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
           ),
        );
    }

}
