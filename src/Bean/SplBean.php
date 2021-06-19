<?php

declare(strict_types=1);

namespace Nashgao\Utils\Bean;

use Closure;
use EasySwoole\Spl\SplBean as Bean;
use JetBrains\PhpStorm\Pure;

abstract class SplBean extends Bean implements SplBeanInterface
{
    #[Pure] 
    public static function of(...$parameters): static
    {
        return new static($parameters);
    }

    public function filter(Closure $fn): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            if ($fn($value, $key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function map(Closure $fn): SplBean
    {
        foreach (get_object_vars($this) as $key => $value) {
            $this->{$key} = $fn($value, $key);
        }

        return static::of(get_object_vars($this));
    }

    public function toArray(array $columns = null, int $filter = null): array
    {
        if (! isset($filter)) { // if filter is not specified, then use not null filter
            $filter = Bean::FILTER_NOT_NULL;
        }

        $array = parent::toArray($columns, $filter);
        array_walk_recursive($array, function (&$item, $key) use ($filter) {
            if (! is_scalar($item) and $item instanceof Bean) {
                $item = $item->toArray(null, $filter);
            }
        });
        return $array;
    }

    public function toArrayWithOneDimension(array $columns = null, int $filter = null): array
    {
        return parent::toArray($columns, $filter);
    }
}
