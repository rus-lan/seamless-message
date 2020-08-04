<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine\Type;

use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram\Content as TelegramContent;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex\Content as YandexContent;

final class MessageTypeEnum extends AbstractEnumType
{
    public const NAME = 'message_type';

    public const type__new_member = 'new_member';
    public const type__left_member = 'left_member';
    public const type__message = 'message';
    public const type__reply = 'reply';

    protected static $choices = [
        self::type__new_member => self::type__new_member,
        self::type__left_member => self::type__left_member,
        self::type__message => self::type__message,
        self::type__reply => self::type__reply,
    ];
}
