<?php

use PhpAmqpLib\Connection\AMQPLazyConnection;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

return [
    'default' => env('QUEUE_CONNECTION', 'rabbitmq'),
    'driver' => 'rabbitmq',
    'queue' => env('RABBITMQ_QUEUE', 'default'),
    'connection' => AMQPLazyConnection::class,
    'job' => RabbitMQJob::class,

    'hosts' => [
        [
            'host' => env('RABBITMQ_HOST', null),
            'port' => env('RABBITMQ_PORT', 5672),
            'user' => env('RABBITMQ_USER', null),
            'password' => env('RABBITMQ_PASSWORD', null),
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