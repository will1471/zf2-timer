<?php

namespace Auth;

trait ServiceTrait
{

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    protected function getAuthenticationService()
    {
        return $this->getServiceLocator()->get('authentication-service');
    }


    /**
     * @return UserService
     */
    protected function getUserService()
    {
        return $this->getServiceLocator()->get('user-service');
    }


    /**
     * This method signature is take from \Zend\ServiceManager\ServiceLocatorAwareInterface
     *
     * This is the only way to guarantee the class using this trait has this method.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    abstract public function getServiceLocator();

}