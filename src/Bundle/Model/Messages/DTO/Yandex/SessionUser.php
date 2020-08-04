<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class SessionUser
{
    /** @var string|null */
    protected $userId;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->userId = $data->user_id ?? null;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }
}
