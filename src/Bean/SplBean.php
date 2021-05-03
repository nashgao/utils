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

    public static function collection(): SplBeanCollection
    {
        return SplBeanCollection::of();
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
