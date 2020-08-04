<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram;

class MessageChat
{
    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $firstName;

    /** @var string|null */
    protected $lastName;

    /** @var string|null */
    protected $username;

    /** @var string|null */
    protected $type;

    /** @var string|null */
    protected $title;

    public function __construct($data = null)
    {
        $this->id = $data->id ?? null;
        $this->firstName = $data->first_name ?? null;
        $this->lastName = $data->last_name ?? null;
        $this->username = $data->username ?? null;
        $this->type = $data->type ?? null;
        $this->title = $data->title ?? null;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
