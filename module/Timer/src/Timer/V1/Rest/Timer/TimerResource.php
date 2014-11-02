<?php

namespace Timer\V1\Rest\Timer;

use Timer\Service as TimerService;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\Authentication\AuthenticationServiceInterface as AuthService;


class TimerResource extends AbstractResourceListener
{

    private $authService;
    private $timerService;


    /**
     * @param \Timer\Service $timerService
     * @param \Zend\Authentication\AuthenticationServiceInterface $authService
     */
    public function __construct(TimerService $timerService, AuthService $authService)
    {
        $this->authService = $authService;
        $this->timerService = $timerService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $this->timerService->createTimer($this->authService->getIdentity(), $data->name);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $timer = $this->timerService->getTimer($this->authService->getIdentity(), $id);
        return [
            'id' => $timer->getId(),
            'name' => $timer->getName(),
        ];
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $timers = $this->timerService->getTimers($this->authService->getIdentity());

        $array = [];
        foreach ($timers as $timer) {
            $array[] = [
                'id' => $timer->getId(),
                'name' => $timer->getName()
            ];
        }

        return new TimerCollection(new \Zend\Paginator\Adapter\ArrayAdapter($array));
    }

}
