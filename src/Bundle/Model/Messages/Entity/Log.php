<?php

namespace RusLan\SeamlessMessage\Bundle\Model\Messages\Entity;

use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

class Log implements Timestampable
{
    use TimestampableEntity;

    /** @var int|null */
    private $id;

    /** @var string */
    private $userAgent = '';

    /** @var string|null */
    private $ip;

    /** @var string|null */
    private $content;

    /** @var string|null */
    private $method;

    /** @var string */
    private $url = '';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return static
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     * @return static
     */
    public function setUserAgent(string $userAgent = ''): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     * @return static
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return static
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     * @return static
     */
    public function setMethod(?string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return static
     */
    public function setUrl(string $url = ''): self
    {
        $this->url = $url;
        return $this;
    }
}
