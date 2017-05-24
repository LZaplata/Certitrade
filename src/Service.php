<?php
/**
 * Created by PhpStorm.
 * User: zap
 * Date: 15.5.17
 * Time: 14:20
 */

namespace LZaplata\Certitrade;


use CertiTrade\APIProblem;
use CertiTrade\Collection;
use CertiTrade\CTServer;
use CertiTrade\Resource;
use Nette\Application\Responses\RedirectResponse;
use Nette\Object;

class Service extends Object
{
    /** @var CTServer */
    public $certitrade;

    /** @var  string */
    public $lang;

    /** @var  string */
    public $currency;

    /**
     * Service constructor.
     *
     * @param CTServer $certitrade
     */
    public function __construct($certitrade)
    {
        $this->certitrade = $certitrade;
    }

    /**
     * Creates new payment
     *
     * @param array $values
     * @return Resource|Collection|APIProblem
     */
    public function createPayment($values)
    {
        $values["language"] = $this->lang;
        $values["currency"] = $this->currency;

        return $this->certitrade->create_card_payment($values);
    }

    /**
     * Process payment by redirecting to Certitrade gateway
     *
     * @param Resource $payment
     * @return RedirectResponse
     */
    public function pay(Resource $payment)
    {
        return new RedirectResponse($payment->getLink("paywin"));
    }

    /**
     * Sets Certitrade gateway language
     *
     * @param string $lang
     * @return self
     */
    public function setLanguage($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Sets Certitrade gateway currency
     *
     * @param string $currency
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Gets payment via Certitrade ID
     *
     * @param int $id
     * @return APIProblem|Collection|Resource
     */
    public function getPayment($id)
    {
        return $this->certitrade->get_payment($id);
    }

    /**
     * Returns true if payment is paid, otherwise returns false
     *
     * @param Resource $payment
     * @return bool
     */
    public function isPaid(Resource $payment)
    {
        if ($payment->state === "READY_FOR_CAPTURE") {
            return true;
        } else return false;
    }
}