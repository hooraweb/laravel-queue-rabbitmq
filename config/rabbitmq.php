<?php

/**
 * This is an example of queue connection configuration.
 * It will be merged into config/queue.php.
 * You need to set proper values in `.env`.
 */

use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

return [

    'driver' => 'rabbitmq',
    'queue' => env('RABBITMQ_QUEUE', 'default'),
    'connection' => PhpAmqpLib\Connection\AMQPLazyConnection::class,
    'job' => RabbitMQJob::class,

    'hosts' => [
        [
            'host' => env('RABBITMQ_HOST', 'rabbitmq.base.hooraweb.com'),
            'port' => env('RABBITMQ_PORT', 5672),
            'user' => env('RABBITMQ_USER', 'root'),
            'password' => env('RABBITMQ_PASSWORD', 'root'),
            'vhost' => env('RABBITMQ_VHOST', '/'),
        ],
    ],

    'options' => [
        'ssl_options' => [
            'cafile' => env('RABBITMQ_SSL_CAFILE', null),
            'local_cert' => env('RABBITMQ_SSL_LOCALCERT', null),
            'local_key' => env('RABBITMQ_SSL_LOCALKEY', null),
            'verify_peer' => env('RABBITMQ_SSL_VERIFY_PEER', true),
            'passphrase' => env('RABBITMQ_SSL_PASSPHRASE', null),
        ],
        'queue' => [
            'exchange' => env('RABBITMQ_QUEUE_EXCHANGE', null),
            'exchange_type' => env('RABBITMQ_QUEUE_EXCHANGE_TYPE', null),
            'exchange_routing_key' => env('RABBITMQ_QUEUE_ROUTING_KEY', null),
        ]
    ],

    /*
     * Set to "horizon" if you wish to use Laravel Horizon.
     */
    'worker' => env('RABBITMQ_WORKER', 'default'),

];
