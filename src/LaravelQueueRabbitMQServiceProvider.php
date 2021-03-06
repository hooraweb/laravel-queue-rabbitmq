<?php

namespace VladimirYuldashev\LaravelQueueRabbitMQ;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;
use VladimirYuldashev\LaravelQueueRabbitMQ\Console\ConsumeCommand;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector;

class LaravelQueueRabbitMQServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/rabbitmq.php',
            'queue.connections.rabbitmq'
        );

        $configDirectory = base_path('config');

        if (file_exists($configDirectory) === false) {
            exec("mkdir $configDirectory");
        }

        if (file_exists($configDirectory.DIRECTORY_SEPARATOR."queue.php") === false) {
            exec("cp ../config/rabbitmq.php $configDirectory/queue.php");
        }

        if (method_exists($this->app, 'configure')) {
            $this->app->configure('queue');
        }

        if ($this->app->runningInConsole()) {
            $this->app->singleton('rabbitmq.consumer', function () {
                $isDownForMaintenance = function () {
                    return $this->app->isDownForMaintenance();
                };

                return new Consumer(
                    $this->app['queue'],
                    $this->app['events'],
                    $this->app[ExceptionHandler::class],
                    $isDownForMaintenance
                );
            });

            $this->app->singleton(ConsumeCommand::class, static function ($app) {
                return new ConsumeCommand(
                    $app['rabbitmq.consumer'],
                    $app['cache.store']
                );
            });

            $this->commands([
                Console\ExchangeDeclareCommand::class,
                Console\QueueBindCommand::class,
                Console\QueueDeclareCommand::class,
                Console\QueuePurgeCommand::class,
                Console\ConsumeCommand::class,
            ]);
        }
    }

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot(): void
    {
        /** @var QueueManager $queue */
        $queue = $this->app['queue'];

        $queue->addConnector('rabbitmq', function () {
            return new RabbitMQConnector($this->app['events']);
        });
    }
}
