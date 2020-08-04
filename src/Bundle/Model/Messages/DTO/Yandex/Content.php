<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

use RusLan\SeamlessMessage\Bundle\Doctrine\Type\ChatTypeEnum;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\ContentInterface;

class Content implements ContentInterface
{
    /** @var Meta|null */
    protected $meta;

    /** @var Session|null */
    protected $session;

    /** @var Request|null */
    protected $request;

    /** @var string|null */
    protected $version;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->version = $data->version ?? null;

        if (isset($data->meta)) {
            $this->meta = new Meta($data->meta);
        }
        if (isset($data->session)) {
            $this->session = new Session($data->session);
        }
        if (isset($data->request)) {
            $this->request = new Request($data->request);
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return ChatTypeEnum::channel_chat;
    }

    /**
     * @return bool
     */
    public function isSession(): bool
    {
        return $this->session instanceof Session;
    }

    /**
     * @return bool
     */
    public function isRequest(): bool
    {
        return $this->request instanceof Request;
    }

    /**
     * @return bool
     */
    public function isMeta(): bool
    {
        return $this->meta instanceof Meta;
    }

    /**
     * @return Meta|null
     */
    public function getMeta(): ?Meta
    {
        return $this->meta;
    }

    /**
     * @return Session|null
     */
    public function getSession(): ?Session
    {
        return $this->session;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }
}
