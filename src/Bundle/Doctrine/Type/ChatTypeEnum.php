<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine\Type;

use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram\Content as TelegramContent;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex\Content as YandexContent;

final class ChatTypeEnum extends AbstractEnumType
{
    public const NAME = 'channel_type';

    public const channel_chat = 'chat';
    public const channel_channel = 'channel';

    protected static $choices = [
        self::channel_chat => self::channel_chat,
        self::channel_channel => self::channel_channel,
    ];
}
