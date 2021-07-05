<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;
use Nashgao\Utils\Bean\SplBean;

if (! function_exists('flatmap')) {
    function flatmap(array $arr, Closure $fn = null): array
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

if (! function_exists('urlmd5')) {
    #[Pure]
    function urlmd5($param): string
    {
        if (! is_string($param)) {
            $param = (string) $param;
        }

        return urlencode(md5($param));
    }
}

if (! function_exists('throws')) {
    /**
     * @throws Throwable
     */
    function throws(Closure $cond, Throwable $throwable)
    {
        $cond() ?: throw $throwable;
    }
}
