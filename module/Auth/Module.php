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
                'authentication-service' => function() {
                    $auth = new \Zend\Authentication\AuthenticationService();
                    $auth->setStorage(new \Zend\Authentication\Storage\Session());
                    return $auth;
                }
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
