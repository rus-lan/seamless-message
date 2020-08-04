<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine\Type;

use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram\Content as TelegramContent;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex\Content as YandexContent;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Slack\Content as SlackContent;

final class SourceTypeEnum extends AbstractEnumType
{
    public const NAME = 'source_type';

    public const source__telegram = 'telegram';
    public const source__yandex = 'yandex';
    public const source__slack = 'slack';

    protected static $choices = [
        self::source__telegram => self::source__telegram,
        self::source__yandex => self::source__yandex,
        self::source__slack => self::source__slack,
    ];

    protected static $dto = [
        self::source__telegram => TelegramContent::class,
        self::source__yandex => YandexContent::class,
        self::source__slack => SlackContent::class,
    ];

    public static function getDTO(string $name): ?string
    {
        return static::$dto[$name] ?? null;
    }
}
