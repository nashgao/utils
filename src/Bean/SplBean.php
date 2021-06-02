<?php

declare(strict_types=1);

namespace Nashgao\Utils\Bean;

use EasySwoole\Spl\SplBean as Bean;

abstract class SplBean extends Bean implements SplBeanInterface
{
    public static function of(...$parameters): SplBean
    {
        return new static($parameters);
    }

    public function filter(callable $fn): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            if ($fn($value, $key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function map(callable $fn): SplBean
    {
        foreach (get_object_vars($this) as $key => $value) {
            $this->{$key} = $fn($value, $key);
        }

        return static::of(get_object_vars($this));
    }

    /**
     * @param null $filter
     */
    public function toArray(array $columns = null, $filter = null): array
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

    /**
     * @param null $filter
     */
    public function toArrayWithOneDimension(array $columns = null, $filter = null): array
    {
        return parent::toArray($columns, $filter);
    }
}
