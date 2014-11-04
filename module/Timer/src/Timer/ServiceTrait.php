<?php

namespace Auth;

trait ServiceTrait
{

    /**
     * @return \Timer\Service
     */
    protected function getTimerService()
    {
        return $this->getServiceLocator()->get('timer-service');
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