<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use DateTimeImmutable;
use DateTimeInterface;
use GraphQL\Language\AST\Node;

final class DateTimeImmutableType
{
    public static function serialize(DateTimeInterface $value): string
    {
        return $value->format(DateTimeInterface::ATOM);
    }

    public static function parseValue(string $value): DateTimeInterface
    {
        return new DateTimeImmutable($value);
    }

    public static function parseLiteral(Node $valueNode): DateTimeInterface
    {
        return new DateTimeImmutable($valueNode->value);
    }
}
