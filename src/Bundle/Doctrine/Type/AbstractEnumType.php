<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType as BaseAbstractEnumType;

abstract class AbstractEnumType extends BaseAbstractEnumType
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return static::NAME;
    }

    public static function getFilteredChoices(string $filter): array
    {
        return array_filter(static::getChoices(), function (string $value) use ($filter) {
            return 0 === strpos($value, $filter);
        });
    }
}
