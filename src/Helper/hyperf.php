<?php

declare(strict_types=1);

use Hyperf\Contract\ConfigInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Swoole\Server;

if (! function_exists('di')) {
    function di(): ContainerInterface
    {
        return ApplicationContext::getContainer();
    }
}

if (! function_exists('config')) {
    function config(): ConfigInterface
    {
        return ApplicationContext::getContainer()->get(ConfigInterface::class);
    }
}

if (! function_exists('dispatch')) {
    function dispatch(object $event): object
    {
        return di()->get(EventDispatcherInterface::class)->dispatch($event);
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
            }
            $workerNum = di()->get(ConfigInterface::class)->get('server.settings.worker_num');
            return $workerNum + $server->worker_id;
        } catch (\Throwable $throwable) {
            return 0;
        }
    }
}
