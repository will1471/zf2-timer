<?php
namespace Timer\V1\Rest\Timer;

class TimerResourceFactory
{
    public function __invoke($services)
    {
        return new TimerResource();
    }
}
