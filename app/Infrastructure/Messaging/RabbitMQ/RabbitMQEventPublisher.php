<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging\RabbitMQ;

use App\Application\Messaging\Contracts\EventPublisherInterface;
use App\Application\Messaging\IntegrationEvent;
use PhpAmqpLib\Message\AMQPMessage;
use RuntimeException;

final readonly class RabbitMQEventPublisher implements EventPublisherInterface
{
    public function __construct(private RabbitMQConnectionFactory $factory)
    {
    }

    public function publish(IntegrationEvent $event): void
    {
        $connection = $this->factory->connect();
        $channel = $connection->channel();

        try {
            $channel->confirm_select();
            $returned = false;
            $channel->set_return_listener(function () use (&$returned): void {
                $returned = true;
            });
            $message = new AMQPMessage($event->toJson(), [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                'message_id' => $event->eventId,
                'type' => $event->eventType,
            ]);
            $channel->basic_publish(
                $message,
                (string) config('integration_messaging.exchange'),
                $event->routingKey(),
                true,
            );
            $channel->wait_for_pending_acks_returns(10.0);
            if ($returned) {
                throw new RuntimeException('Event could not be routed to a queue.');
            }
        } finally {
            $channel->close();
            $connection->close();
        }
    }
}
