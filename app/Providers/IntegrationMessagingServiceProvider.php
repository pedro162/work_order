<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Messaging\Contracts\EventPublisherInterface;
use App\Infrastructure\Messaging\RabbitMQ\RabbitMQEventPublisher;
use Illuminate\Support\ServiceProvider;

final class IntegrationMessagingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EventPublisherInterface::class, RabbitMQEventPublisher::class);
    }
}
