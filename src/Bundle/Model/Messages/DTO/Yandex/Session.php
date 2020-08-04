<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class Session
{
    /** @var int|null */
    protected $messageId;

    /** @var string|null */
    protected $sessionId;

    /** @var string|null */
    protected $skillId;

    /** @var SessionUser|null */
    protected $user;

    /** @var SessionApplication|null */
    protected $application;

    /** @var bool */
    protected $new;

    /** @var object|null */
    protected $source;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->source = $data;

        $this->messageId = $data->message_id ?? null;
        $this->sessionId = $data->session_id ?? null;
        $this->skillId = $data->skill_id ?? null;
        $this->new = $data->new ?? false;

        if (isset($data->user)) {
            $this->user = new SessionUser($data->user);
        }
        if (isset($data->application)) {
            $this->application = new SessionApplication($data->application);
        }
    }

    /**
     * @return object|null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->user instanceof SessionUser;
    }

    /**
     * @return bool
     */
    public function isApplication(): bool
    {
        return $this->application instanceof SessionApplication;
    }

    /**
     * @return int|null
     */
    public function getMessageId(): ?int
    {
        return $this->messageId;
    }

    /**
     * @return string|null
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * @return string|null
     */
    public function getSkillId(): ?string
    {
        return $this->skillId;
    }

    /**
     * @return SessionUser|null
     */
    public function getUser(): ?SessionUser
    {
        return $this->user;
    }

    /**
     * @return SessionApplication|null
     */
    public function getApplication(): ?SessionApplication
    {
        return $this->application;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->new;
    }
}
