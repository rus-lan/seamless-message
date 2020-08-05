<?php

namespace RusLan\SeamlessMessage\Bundle\Model\User\Entity;

use RusLan\SeamlessMessage\Bundle\Doctrine\Type\SourceTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use RusLan\SeamlessMessage\Bundle\Model\User\Entity\MessagesUser as Message;

class User implements UserInterface, Timestampable, SoftDeleteable
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $accountUid;

    /** @var string|null */
    protected $username;

    /** @var string|null */
    protected $language;

    /** @var array */
    protected $history = [];

    /** @var Message[]|Collection */
    protected $messages;

    /** @var bool */
    protected $bot = false;

    /** @var string|null */
    protected $type;

    /** @var string */
    protected $botName = '';

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function matchMessage(Message $message): bool
    {
        return $this->getMessages()->contains($message);
    }

    public function setMessages($messages): self
    {
        foreach ($messages as $message) {
            if ($message instanceof Message) {
                $this->addMessage($message);
            }
        }

        return $this;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->matchMessage($message)) {
            $this->messages->add($message);
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        $this->messages->removeElement($message);
        $message->setUser(null);

        return $this;
    }

    /**
     * @return string
     */
    public function getBotName(): string
    {
        return $this->botName;
    }

    /**
     * @param string $botName
     * @return static
     */
    public function setBotName(string $botName): self
    {
        $this->botName = $botName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return static
     */
    public function setType(string $type = null): self
    {
        $this->type = in_array($type, SourceTypeEnum::getValues()) ? $type : $this->type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->accountUid !== null;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return (bool) $this->bot;
    }

    /**
     * @param bool|null $bot
     * @return static
     */
    public function setBot(?bool $bot = false): self
    {
        $this->bot = (bool) $bot;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountUid(): ?string
    {
        return $this->accountUid;
    }

    /**
     * @param string|null $accountUid
     * @return static
     */
    public function setAccountUid(?string $accountUid): self
    {
        $this->accountUid = $accountUid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return static
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     * @return static
     */
    public function setLanguage(?string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return array
     */
    public function getHistory(): array
    {
        return $this->history;
    }

    /**
     * @param array $history
     * @return static
     */
    public function setHistory(array $history): self
    {
        $this->history = $history;
        return $this;
    }
}
