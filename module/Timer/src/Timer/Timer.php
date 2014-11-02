<?php

namespace Timer;


class Timer extends \Will1471\Timer\Timer
{

    /**
     *
     * @var Entity\Timer;
     */
    private $entity;

    private $om;


    public function __construct(\Timer\Entity\Timer $timer, \Doctrine\Common\Persistence\ObjectManager $om)
    {
        $this->entity = $timer;
        $this->om = $om;

        $events = [];
        foreach ($this->entity->getTimerEvents() as $timerEvent) {
            $events[] = new \Will1471\Timer\State\Event($timerEvent->getType(), $timerEvent->getDatetime());
        }
        parent::__construct($events);
    }


    protected function pushEvent(\Will1471\Timer\State\Event $event)
    {
        parent::pushEvent($event);

        $this->entity->addTimerEvent($e = new \Timer\Entity\TimerEvent());
        $e->setDatetime($event->getDateTime());
        $e->setType($event->getType());

        $this->om->persist($e);
        $this->om->flush();
    }

}
