<?php

namespace Timer;

use Auth\Entity\User;
use Timer\Entity\Timer;

class Service
{

    private $om;


    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     */
    public function __construct(\Doctrine\Common\Persistence\ObjectManager $om)
    {
        $this->om = $om;
    }


    /**
     * @param \Auth\Entity\User $user
     * @param string $timerName
     *
     * @return \Timer\Entity\Timer
     */
    public function createTimer(User $user, $timerName)
    {
        $timer = new Timer();
        $timer->setName($timerName);
        $timer->setUser($user);

        $this->om->persist($timer);
        $this->om->flush();

        return $timer;
    }


    /**
     * @param \Auth\Entity\User $user
     *
     * @return Timer[]
     */
    public function getTimers(User $user)
    {
        return $this->om->getRepository(Timer::class)
            ->findBy(['user' => $user]);
    }


    /**
     * @param \Auth\Entity\User $user
     * @param int $id
     *
     * @return Timer
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getTimer(User $user, $id)
    {
        $timers = $this->om->getRepository(Timer::class)
            ->findBy(['user' => $user, 'id' => $id], [], 1);

        if (isset($timers[0])) {
            return $timers[0];
        }

        throw new \Doctrine\ORM\EntityNotFoundException();
    }

}
