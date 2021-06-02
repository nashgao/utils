<?php

declare(strict_types=1);

use Nashgao\Utils\Bean\SplBean;

if (! function_exists('flatmap')) {
    function flatmap(array $arr, callable $fn = null): array
    {
        if (! isset($fn)) {
            $fn = function (array $arr) {
                return $arr;
            };
        }

        return array_merge(...array_map($fn, $arr));
    }
}

if (! function_exists('filterBean')) {
    /**
     * Filter the bean and to array with not null.
     */
    function filterBean(SplBean $bean, array $filter = []): array
    {
        $validKeys = array_diff_key($bean->toArrayWithMapping(), array_fill_keys($filter, null));
        if (empty($validKeys)) {
            return [];
        }
        return $bean->toArray(array_keys(array_diff_key($bean->toArrayWithMapping(), array_fill_keys($filter, null))), $bean::FILTER_NOT_NULL);
    }
}
