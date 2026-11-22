<?php

declare(strict_types=1);

namespace App\Application\Messaging\Contracts;

use App\Application\Messaging\IntegrationEvent;

interface EventPublisherInterface
{
    public function publish(IntegrationEvent $event): void;
}
