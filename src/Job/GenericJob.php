<?php

use PhpAmqpLib\Message\AMQPMessage;

class GenericJob
{
    /**
     * @var AMQPMessage $message
     */
    public $message;

    public function __construct(AMQPMessage $message)
    {
        $this->message = $message;
    }

    public function fire()
    {
        return $message;
    }
}