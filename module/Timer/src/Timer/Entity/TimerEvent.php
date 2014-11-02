<?php

namespace Timer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TimerEvent
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
    protected $type;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $datetime;

    /**
     * @ORM\ManyToOne(targetEntity="Timer", inversedBy="timerEvents")
     * @ORM\JoinColumn(name="timer_id", referencedColumnName="id")
     */
    protected $timer;


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
    public function getType()
    {
        return $this->type;
    }


    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }


    /**
     * @return Timer
     */
    public function getTimer()
    {
        return $this->timer;
    }


    /**
     * @param string $type
     *
     * @return \Timer\Entity\TimerEvent
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


    /**
     * @param \DateTime $datetime
     *
     * @return \Timer\Entity\TimerEvent
     */
    public function setDatetime(\DateTimeInterface $datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }


    /**
     * @param Timer $timer
     *
     * @return \Timer\Entity\TimerEvent
     */
    public function setTimer(Timer $timer)
    {
        $this->timer = $timer;
        return $this;
    }

}
