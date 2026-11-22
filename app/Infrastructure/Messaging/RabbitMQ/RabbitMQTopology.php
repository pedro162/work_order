<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging\RabbitMQ;

use PhpAmqpLib\Wire\AMQPTable;

final readonly class RabbitMQTopology
{
    public function __construct(private RabbitMQConnectionFactory $factory)
    {
    }

    public function declare(): void
    {
        $connection = $this->factory->connect();
        $channel = $connection->channel();
        try {
            $exchange = (string) config('integration_messaging.exchange');
            $queue = (string) config('integration_messaging.queue');
            $dlx = (string) config('integration_messaging.dlx');
            $dlq = (string) config('integration_messaging.dlq');
            $channel->exchange_declare($exchange, 'topic', false, true, false);
            $channel->exchange_declare($dlx, 'direct', false, true, false);
            $channel->queue_declare($dlq, false, true, false, false);
            $channel->queue_bind($dlq, $dlx, $dlq);
            $channel->queue_declare($queue, false, true, false, false, false, new AMQPTable([
                'x-dead-letter-exchange' => $dlx,
                'x-dead-letter-routing-key' => $dlq,
            ]));
            foreach (config('integration_messaging.allowed_producers', []) as $producer) {
                $channel->queue_bind($queue, $exchange, "{$producer}.customer.created.v1");
                $channel->queue_bind($queue, $exchange, "{$producer}.customer.updated.v1");
            }
        } finally {
            $channel->close();
            $connection->close();
        }
    }
}
