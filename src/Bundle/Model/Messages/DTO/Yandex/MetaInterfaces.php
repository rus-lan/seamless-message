<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class MetaInterfaces
{
    /** @var object|null */
    protected $screen;

    /** @var object|null */
    protected $payments;

    /** @var object|null */
    protected $accountLinking;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->screen = $data->screen ?? null;
        $this->payments = $data->payments ?? null;
        $this->accountLinking = $data->accountLinking ?? null;
    }

    /**
     * @return object|null
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * @return object|null
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @return object|null
     */
    public function getAccountLinking()
    {
        return $this->accountLinking;
    }
}
