<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram;

class MessageEntity
{
    /** @var int|null */
    protected $offset;

    /** @var int|null */
    protected $length;

    /** @var string|null */
    protected $type;

    public function __construct($data = null)
    {
        $this->offset = $data->offset ?? null;
        $this->length = $data->length ?? null;
        $this->type = $data->type ?? null;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
