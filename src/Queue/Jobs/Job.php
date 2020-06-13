<?php

namespace VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

abstract class Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    abstract function data(): array;

    public function queue()
    {
        $data = $this->data();

        if (Arr::has($data, 'job') === false) {
            throw new Exception("Missing job keyword in data array");
        }

        $queue = app('queue');
        $queue->pushRaw(json_encode($data), $this->queue);
    }
}
