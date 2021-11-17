<?php

namespace App\Services;

use Lucid\Units\Operation;
use ReflectionClass;

class BaseOperation extends Operation
{
    public function runInQueue($unit, array $arguments = [], $queue = '')
    {
        $connection = config('queue.default');
        $queue = $queue ?: config('queue.connections.'.$connection.'.queue');

        // instantiate and queue the unit
        $reflection = new ReflectionClass($unit);
        $instance = $reflection->newInstanceArgs($arguments);
        $instance->onQueue((string) $queue);

        return $this->dispatch($instance);
    }
}
