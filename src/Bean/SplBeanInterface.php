<?php

declare(strict_types=1);

namespace Nashgao\Utils\Bean;

interface SplBeanInterface
{
    public function issetPrimaryKey(): bool;

    public function getPrimaryKey();

    public static function collection();

    public static function of();

    public function toArray(array $columns = null, $filter = null);
}
