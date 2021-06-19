<?php

declare(strict_types=1);

namespace Nashgao\Utils\Bean;

interface SplBeanInterface
{
    public function issetPrimaryKey(): bool;

    public function getPrimaryKey(): mixed;

    public static function of(): static;

    public function toArray(array $columns = null, $filter = null): array;
}
