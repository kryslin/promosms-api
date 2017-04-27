<?php

namespace PromoSMS\Api\Sms;

/**
 * Class SmsInterface
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
interface SmsInterface
{
    /**
     * @return null|string
     */
    public function getMessage();

    /**
     * Set text message content.
     *
     * @param string $message
     * @return \PromoSMS\Api\Sms\SmsInterface
     */
    public function setMessage($message);

    /**
     * Return receiver number
     *
     * @return string
     */
    public function getReceiver();

    /**
     * Set receiver number
     *
     * @param string $number
     * @return bool
     */
    public function setReceiver($number);

    /**
     * Check if message must fit into one text message
     *
     * @return bool
     */
    public function isSingle();

    /**
     * Disallows to send sms with content that does not fit into one text message
     * Can be disabled by passing false as first argument.
     *
     * @param bool $single
     * @return \PromoSMS\Api\Sms\SmsInterface
     */
    public function setSingle($single = true);

    /**
     * @return boolean
     */
    public function isPl();

    /**
     * @param bool $pl
     * @return bool
     */
    public function setPl($pl = true);

    /**
     * @return string
     */
    function getType();

    /**
     * @return string
     */
    function getFrom();

    /**
     * @param $from
     */
    function setFrom($from);
}