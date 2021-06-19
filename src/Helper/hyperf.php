<?php

declare(strict_types=1);

use Hyperf\Contract\ConfigInterface;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Swoole\Server;

if (! function_exists('di')) {
    #[Pure]
    function di(): ContainerInterface
    {
        return ApplicationContext::getContainer();
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
        } catch (\Throwable) {
            return null;
        }
    }
}

if (! function_exists('getWorkerId')) {
    function getWorkerId(): int
    {
        try {
            return getServer()->worker_id;
        } catch (\Throwable) {
            return 0;
        }
    }
}

if (! function_exists('getWorkerNumber')) {
    function getWorkerNum(): int
    {
        return di()->get(ConfigInterface::class)->get('server.settings.worker_num');
    }
}

if (! function_exists('isTaskWorker')) {
    function isTaskWorker(): bool
    {
        return getServer()->taskworker;
    }
}

if (! function_exists('generateId')) {
    function generateId(): int
    {
        return di()->get(IdGeneratorInterface::class)->generate();
    }
}
