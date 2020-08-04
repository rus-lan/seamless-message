<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Message
{
    /** @var int|null */
    protected $messageId;

    /** @var MessageFrom|null */
    protected $from;

    /** @var MessageChat|null */
    protected $chat;

    /** @var \DateTime|null */
    protected $date;

    /** @var string|null */
    protected $text;

    /** @var self|null*/
    protected $replyToMessage;

    /** @var MessageFrom|null*/
    protected $leftChatMember;

    /** @var MessageFrom|null*/
    protected $newChatMember;

    /** @var MessageFrom[]|array|Collection */
    protected $newChatMembers;

    /** @var MessageEntity[]|array|Collection */
    protected $entities;

    /** @var object|null */
    protected $source;

    public function __construct($data = null)
    {
        $this->source = $data;
        $this->entities = new ArrayCollection();
        $this->replyToMessage = new ArrayCollection();
        $this->newChatMembers = new ArrayCollection();

        $this->messageId = $data->message_id ?? null;
        $this->date = $data->date ?? null;
        $this->text = $data->text ?? null;

        if (isset($data->from)) {
            $this->from = new MessageFrom($data->from);
        }
        if (isset($data->chat)) {
            $this->chat = new MessageChat($data->chat);
        }
        if (isset($data->left_chat_member)) {
            $this->leftChatMember = new MessageFrom($data->left_chat_member);
        }
        if (isset($data->new_chat_member)) {
            $this->newChatMember = new MessageFrom($data->new_chat_member);
        }
        if (isset($data->reply_to_message)) {
            $this->replyToMessage = new static($data->reply_to_message);
        }
        foreach ($data->entities ?? [] as $entity) {
            $this->entities->add(new MessageEntity($entity));
        }
        foreach ($data->new_chat_members ?? [] as $new_chat_member) {
            $this->newChatMembers->add(new MessageFrom($new_chat_member));
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
    public function isNewChatMember(): bool
    {
        return $this->newChatMember instanceof MessageFrom;
    }

    /**
     * @return MessageFrom|null
     */
    public function getNewChatMember()
    {
        return $this->newChatMember;
    }

    /**
     * @return bool
     */
    public function isLeftChatMember(): bool
    {
        return $this->leftChatMember instanceof MessageFrom;
    }

    /**
     * @return MessageFrom|null
     */
    public function getLeftChatMember()
    {
        return $this->leftChatMember;
    }

    /**
     * @return bool
     */
    public function isReplyToMessage(): bool
    {
        return $this->replyToMessage instanceof static;
    }

    /**
     * @return self|null
     */
    public function getReplyToMessage()
    {
        return $this->replyToMessage;
    }

    /**
     * @return bool
     */
    public function isFrom(): bool
    {
        return $this->from instanceof MessageFrom;
    }

    /**
     * @return bool
     */
    public function isChat(): bool
    {
        return $this->chat instanceof MessageChat;
    }

    /**
     * @return int|null
     */
    public function getMessageId(): ?int
    {
        return $this->messageId;
    }

    /**
     * @return MessageFrom|null
     */
    public function getFrom(): ?MessageFrom
    {
        return $this->from;
    }

    /**
     * @return MessageChat|null
     */
    public function getChat(): ?MessageChat
    {
        return $this->chat;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return MessageEntity[]|array|Collection
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @return MessageFrom[]|array|Collection
     */
    public function getNewChatMembers()
    {
        return $this->newChatMembers;
    }
}
