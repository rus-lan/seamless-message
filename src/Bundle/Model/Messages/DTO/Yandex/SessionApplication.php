<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class SessionApplication
{
    /** @var string|null */
    protected $applicationId;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->applicationId = $data->application_id ?? null;
    }

    /**
     * @return string|null
     */
    public function getApplicationId(): ?string
    {
        return $this->applicationId;
    }
}
