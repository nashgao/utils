<?php

declare(strict_types=1);

namespace Nashgao\Utils\Bean;

interface SplInterface
{
    public function issetPrimaryKey():bool;
    public function getPrimaryKey();
    public function toArray(array $columns = null, $filter = null);
}
