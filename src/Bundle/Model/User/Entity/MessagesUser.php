<?php

namespace RusLan\SeamlessMessage\Bundle\Model\User\Entity;

use RusLan\SeamlessMessage\Bundle\Doctrine\Type\MessageTypeEnum;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

class MessagesUser implements Timestampable
{
    use TimestampableEntity;

    /** @var int|null */
    private $id;

    /** @var int */
    private $messageId;

    /** @var User|null */
    private $user;

    /** @var int|null */
    private $reply;

    /** @var string|null */
    private $text;

    /** @var string */
    private $type = MessageTypeEnum::type__message;

    /** @var array */
    private $data = [];

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
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     * @return static
     */
    public function setMessageId(int $messageId): self
    {
        $this->messageId = $messageId;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return static
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReply(): ?int
    {
        return $this->reply;
    }

    /**
     * @param int|null $reply
     * @return static
     */
    public function setReply(?int $reply): self
    {
        $this->reply = $reply;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return static
     */
    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return static
     */
    public function setType(string $type): self
    {
        $this->type = in_array($type, MessageTypeEnum::getChoices()) ? $type : $this->type;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return static
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
