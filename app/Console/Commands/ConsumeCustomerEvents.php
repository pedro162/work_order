<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Application\Messaging\InboundEventProcessor;
use App\Application\Messaging\IntegrationEvent;
use App\Infrastructure\Messaging\RabbitMQ\RabbitMQConnectionFactory;
use Illuminate\Console\Command;
use PhpAmqpLib\Message\AMQPMessage;
use Throwable;

final class ConsumeCustomerEvents extends Command
{
    protected $signature = 'integration:consume-customers';

    protected $description = 'Consume remote customer events with ACK on commit';

    public function handle(
        RabbitMQConnectionFactory $factory,
        InboundEventProcessor $processor
    ): int {
        $connection = $factory->connect();
        $channel = $connection->channel();

        try {
            $channel->basic_qos(
                0,
                max(1, (int) config('integration_messaging.prefetch', 10)),
                false
            );

            $channel->basic_consume(
                (string) config('integration_messaging.queue'),
                '',
                false,
                false,
                false,
                false,
                function (AMQPMessage $message) use ($processor, $channel): void {
                    try {
                        $event = IntegrationEvent::fromJson(
                            $message->getBody()
                        );

                        $processed = $processor->process($event);

                        // Confirm only after the database transaction commits.
                        $channel->basic_ack(
                            $message->delivery_info['delivery_tag']
                        );

                        $this->info(
                            $processed
                                ? "Event {$event->eventId} processed successfully."
                                : "Event {$event->eventId} already processed."
                        );
                    } catch (Throwable $exception) {
                        report($exception);

                        $this->error(
                            'Failed to process customer event: '
                                . $exception->getMessage()
                        );

                        // Reject without requeueing.
                        // RabbitMQ forwards the message to the DLQ
                        // if dead-lettering is configured.
                        $channel->basic_nack(
                            $message->delivery_info['delivery_tag'],
                            false,
                            false
                        );
                    }
                }
            );

            $this->info('Consuming customer integration events.');

            while (count($channel->callbacks) > 0) {
                $channel->wait();
            }

            return self::SUCCESS;
        } finally {
            $channel->close();
            $connection->close();
        }
    }
}
