<?php

declare(strict_types=1);

use Hyperf\Utils\ApplicationContext;
use Nashgao\Utils\Bean\SplBean;
use Psr\Container\ContainerInterface;
use Swoole\Server;
use Hyperf\Contract\ConfigInterface;

if (! function_exists('di')) {
    function di(): ContainerInterface
    {
        return ApplicationContext::getContainer();
    }
}

if (! function_exists('filterBean')) {
    /**
     * Filter the bean and to array with not null.
     * @param SplBean $bean
     * @param array $filter
     * @return array
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

if (! function_exists('getServer')) {
    function getServer(): ?Server
    {
        try {
            return di()->get(Server::class);
        } catch (\Throwable $throwable) {
            return null;
        }
    }
}

if (! function_exists('getWorkerId')) {
    function getWorkerId(): int
    {
        try {
            $server = getServer();
            if (! $server->taskworker) {
                return $server->worker_id;
            } else {
                $workerNum = di()->get(ConfigInterface::class)->get("server.settings.worker_num");
                return $workerNum + $server->worker_id;
            }
        } catch (\Throwable $throwable) {
            return 0;
        }
    }
}