<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram;

class MessageFrom
{
    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $firstName;

    /** @var string|null */
    protected $lastName;

    /** @var string|null */
    protected $username;

    /** @var bool|null */
    protected $isBot;

    /** @var string|null */
    protected $languageCode;

    public function __construct($data = null)
    {
        $this->id = $data->id ?? null;
        $this->firstName = $data->first_name ?? null;
        $this->lastName = $data->last_name ?? null;
        $this->username = $data->username ?? null;
        $this->isBot = $data->is_bot ?? null;
        $this->languageCode = $data->language_code ?? null;
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
     * @return bool|null
     */
    public function getIsBot(): ?bool
    {
        return $this->isBot;
    }

    /**
     * @return string|null
     */
    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }
}
