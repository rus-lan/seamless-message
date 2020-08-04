<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class RequestNlu
{
    /** @var array */
    protected $tokens;

    /** @var array */
    protected $entities;

    /** @var object|null */
    protected $intents;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->tokens = $data->tokens ?? [];
        $this->entities = $data->entities ?? [];
        $this->intents = $data->intents ?? null;
    }
}
