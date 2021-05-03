<?php

declare(strict_types=1);

namespace Nashgao\Utils\Bean;

class SplBeanCollection
{
    protected static array $collection;

    public static function of(): SplBeanCollection
    {
        return new static();
    }
}
