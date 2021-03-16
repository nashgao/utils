<?php

declare(strict_types=1);

namespace Nashgao\Utils\Bean;

interface SplBeanInterface
{
    public function issetPrimaryKey():bool;
    public function getPrimaryKey();
    public function toArray(array $columns = null, $filter = null);
}
