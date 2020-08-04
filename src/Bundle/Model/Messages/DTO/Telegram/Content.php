<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram;

use RusLan\SeamlessMessage\Bundle\Doctrine\Type\ChatTypeEnum;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\ContentInterface;

class Content implements ContentInterface
{
    /** @var int|null */
    protected $updateId;

    /** @var Message|null */
    protected $message;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->updateId = $data->update_id ?? null;
        if (isset($data->message)) {
            $this->message = new Message($data->message);
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->isMessage()
            &&
            (
                !$this->getMessage()->isChat()
                || !$this->getMessage()->isFrom()
                || $this->getMessage()->getChat()->getId() !== $this->getMessage()->getFrom()->getId()
                || $this->getMessage()->isLeftChatMember()
                || $this->getMessage()->isNewChatMember()
            )
            ? ChatTypeEnum::channel_channel
            : ChatTypeEnum::channel_chat
        ;
    }

    /**
     * @return bool
     */
    public function isChat(): bool
    {
        return $this->getType() === ChatTypeEnum::channel_chat;
    }

    /**
     * @return bool
     */
    public function isChannel(): bool
    {
        return $this->getType() === ChatTypeEnum::channel_channel;
    }

    /**
     * @return int|null
     */
    public function getUpdateId(): ?int
    {
        return $this->updateId;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isMessage(): bool
    {
        return $this->message instanceof Message;
    }
}
