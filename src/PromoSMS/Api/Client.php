<?php

namespace PromoSMS\Api;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Client as HttpClient;
use PromoSMS\Api\Response\Response;
use PromoSMS\Api\Sms\SmsInterface;

/**
 * Class Client
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class Client
{
    protected $apiUrl = 'https://api.promosms.pl/';

    /**
     * @var \Guzzle\Http\ClientInterface
     */
    protected $client;
    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @param $login
     * @param $password
     * @param ClientInterface $client
     */
    public function __construct($login, $password, ClientInterface $client = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->client = $client;
    }

    /**
     * Return api url
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param string $url
     * @return \PromoSMS\Api\Client
     */
    public function setApiUrl($url)
    {
        $this->apiUrl = $url;

        return $this;
    }

    /**
     * @param \PromoSMS\Api\Sms\SmsInterface $sms
     * @throws \InvalidArgumentException
     * @return \PromoSMS\Api\Response\Response
     */
    public function send(SmsInterface $sms)
    {
        $this->validateSms($sms);
        $response = $this->getClient()->post($this->getSendUrl(), array(), $this->buildQueryParams($sms))->send();

        return new Response($response->getBody(true));
    }

    /**
     * @return HttpClient|ClientInterface
     */
    protected function getClient()
    {
        if (!isset($this->client)) {
            $this->client = new HttpClient();
        }

        return $this->client;
    }

    /**
     * Add send.php to api url
     *
     * @return string
     */
    protected function getSendUrl()
    {
        return $this->apiUrl . 'send.php';
    }

    /**
     * @param SmsInterface $sms
     * @throws \InvalidArgumentException
     */
    protected function validateSms(SmsInterface $sms)
    {
        $receiver = $sms->getReceiver();

        if (empty($receiver)) {
            throw new \InvalidArgumentException('Cant send sms with empty receiver');
        }

        $message = $sms->getMessage();

        if (empty($message)) {
            throw new \InvalidArgumentException('Cant send sms with empty message');
        }
    }

    /**
     * Build query params array for SmsInterface
     *
     * @param \PromoSMS\Api\Sms\SmsInterface $sms
     * @return array
     */
    protected function buildQueryParams(SmsInterface $sms)
    {
        $params = array(
            'login' => $this->login,
            'pass' => $this->password,
            'type' => $sms->getType(),
            'to' =>  $sms->getReceiver(),
            'message' => $sms->getMessage()
        );

        if (!$sms->isSingle()) {
            $params['single'] = 0;
        }

        if ($sms->isPl()) {
            $params['pl'] = 1;
        }

        if ($sms->hasTime()) {
            $params['time'] = $sms->getTime();
        }

        return $params;
    }
}