<?php

declare(strict_types=1);

if (! function_exists('urlmd5')) {
    function urlmd5($param): string
    {
        if (! is_string($param)) {
            $param = (string) $param;
        }

        return urlencode(md5($param));
    }
}
