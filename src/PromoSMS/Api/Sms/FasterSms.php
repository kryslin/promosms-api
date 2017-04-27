<?php

namespace PromoSMS\Api\Sms;

class FasterSms implements SmsInterface
{
    /**
     * @var string|null
     */
    protected $message;

    /**
     * @var string
     */
    protected $receiver;

    /**
     * @var bool
     */
    protected $single;

    /**
     * @var bool
     */
    protected $pl;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var bool
     */
    protected $abroad;

    /**
     * @var string
     */
    protected $from;

    public function __construct()
    {
        $this->single = true;
        $this->pl = false;
        $this->abroad = false;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'faster';
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiver($number)
    {
        $this->receiver = $number;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSingle($single = true)
    {
        $this->single = $single;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isSingle()
    {
        return $this->single;
    }

    /**
     * {@inheritdoc}
     */
    public function isPl()
    {
        return $this->pl;
    }

    /**
     * {@inheritdoc}
     */
    public function setPl($pl = true)
    {
        $this->pl = $pl;

        return $pl;
    }

    /**
     * @return bool
     */
    public function hasTime()
    {
        return isset($this->time);
    }

    /**
     * @param \DateTime $time
     * @throws \InvalidArgumentException
     */
    public function setTime(\DateTime $time)
    {
        $now = new \DateTime();
        if ($time <= $now) {
            throw new \InvalidArgumentException("Cant set past time as a send time");
        }

        $this->time = $time->getTimestamp();
    }

    /**
     * Return time as a timestamp
     *
     * @return int
     */
    public function getTime()
    {
        if ($this->hasTime()) {
            return $this->time;
        }
    }
}