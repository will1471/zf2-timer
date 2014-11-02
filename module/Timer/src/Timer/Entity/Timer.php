<?php

namespace Timer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Timer
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="\Auth\Entity\User", inversedBy="timers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="TimerEvent", mappedBy="timer", fetch="EAGER")
     **/
    protected $timerEvents;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return \Auth\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @return TimerEvent[]
     */
    public function getTimerEvents()
    {
        return $this->timerEvents;
    }


    /**
     * @param string $name
     *
     * @return \Timer\Entity\Timer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @param \Auth\Entity\User $user
     *
     * @return \Timer\Entity\Timer
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * @param TimerEvents[] $timerEvents
     *
     * @return \Timer\Entity\Timer
     */
    public function setTimerEvents($timerEvents)
    {
        $this->timerEvents = $timerEvents;
        return $this;
    }

}
