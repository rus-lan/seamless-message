<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Slack;

use RusLan\SeamlessMessage\Bundle\Doctrine\Type\ChatTypeEnum;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\ContentInterface;

class Content implements ContentInterface
{
    /** @var object|null */
    protected $source;

    /** @var string|null */
    protected $token;

    /** @var object|null */
    protected $payload;

    /** @var string|null */
    protected $teamId;

    /** @var string|null */
    protected $teamDomain;

    /** @var string|null */
    protected $channelId;

    /** @var string|null */
    protected $channelName;

    /** @var string|null */
    protected $userId;

    /** @var string|null */
    protected $userName;

    /** @var string|null */
    protected $command;

    /** @var string|null */
    protected $text;

    /** @var string|null */
    protected $responseUrl;

    /** @var string|null */
    protected $triggerId;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->source = $data;
        $this->token = $data->token ?? null;
        $this->payload = $data->payload ?? null;
        $this->teamId = $data->team_id ?? null;
        $this->teamDomain = $data->team_domain ?? null;
        $this->channelId = $data->channel_id ?? null;
        $this->channelName = $data->channel_name ?? null;
        $this->userId = $data->user_id ?? null;
        $this->userName = $data->user_name ?? null;
        $this->command = $data->command ?? null;
        $this->text = $data->text ?? null;
        $this->responseUrl = $data->response_url ?? null;
        $this->triggerId = $data->trigger_id ?? null;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->isChannelId()
            ? ChatTypeEnum::channel_channel
            : ChatTypeEnum::channel_chat
        ;
    }

    /**
     * @return object|null
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return bool
     */
    public function isPayload(): bool
    {
        return (bool) $this->getPayload();
    }

    /**
     * @param object|null $payload
     * @return Content
     */
    public function setPayload($payload): Content
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->getToken()
            && $this->getUserId()
            && $this->getCommand()
            && $this->getChannelId()
        ;
    }

    /**
     * @return object|null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return string|null
     */
    public function getTeamId(): ?string
    {
        return $this->teamId;
    }

    /**
     * @return string|null
     */
    public function getTeamDomain(): ?string
    {
        return $this->teamDomain;
    }

    /**
     * @return string|null
     */
    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    /**
     * @return bool
     */
    public function isChannelId(): bool
    {
        return (bool) $this->getChannelId();
    }

    /**
     * @return string|null
     */
    public function getChannelName(): ?string
    {
        return $this->channelName;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @return string|null
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getResponseUrl(): ?string
    {
        return $this->responseUrl;
    }

    /**
     * @return string|null
     */
    public function getTriggerId(): ?string
    {
        return $this->triggerId;
    }
}
