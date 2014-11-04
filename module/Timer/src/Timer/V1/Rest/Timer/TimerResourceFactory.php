<?php

namespace Timer\V1\Rest\Timer;

use Zend\ServiceManager\ServiceLocatorInterface;


class TimerResourceFactory
{

    /**
     * Provides getAuthenticationService()
     */
    use \Auth\ServiceTrait;

    /**
     * Provides getTimerService()
     */
    use \Timer\ServiceTrait;


    /**
     * @var ServiceLocatorInterface
     */
    private $services;


    /**
     * @param ServiceLocatorInterface $services
     *
     * @return \Timer\V1\Rest\Timer\TimerResource
     */
    public function __invoke(ServiceLocatorInterface $services)
    {
        $this->$services = $services;

        return new TimerResource(
            $this->getTimerService(),
            $this->getAuthenticationService()
        );
    }


    /**
     * Implement required method for service traits.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->services;
    }

}
