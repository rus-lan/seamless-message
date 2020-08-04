<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class RequestMarkup
{
    /** @var bool */
    protected $dangerousContext;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->dangerousContext = $data->dangerous_context ?? false;
    }

    /**
     * @return bool
     */
    public function isDangerousContext(): bool
    {
        return $this->dangerousContext;
    }
}
