<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;

final class RabbitMQConnectionFactory
{
    public function connect(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            (string) config('integration_messaging.host'),
            (int) config('integration_messaging.port'),
            (string) config('integration_messaging.user'),
            (string) config('integration_messaging.password'),
            (string) config('integration_messaging.vhost'),
        );
    }
}
