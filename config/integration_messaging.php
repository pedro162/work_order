<?php

declare(strict_types=1);

return [
    'host' => env('RABBITMQ_HOST', 'rabbitmq'),
    'port' => (int) env('RABBITMQ_PORT', 5672),
    'user' => env('RABBITMQ_USER', 'work_order'),
    'password' => env('RABBITMQ_PASSWORD', ''),
    'vhost' => env('RABBITMQ_VHOST', '/'),
    'exchange' => env('RABBITMQ_EXCHANGE', 'domain.events'),
    'queue' => env('RABBITMQ_QUEUE', 'work_order.customer.events'),
    'dlx' => env('RABBITMQ_DLX', 'domain.events.dead'),
    'dlq' => env('RABBITMQ_DLQ', 'work_order.customer.events.dead'),
    'producer' => env('INTEGRATION_PRODUCER', 'work_order'),
    'allowed_producers' => array_values(array_filter(array_map('trim', explode(',', (string) env('INTEGRATION_ALLOWED_PRODUCERS', 'customer_api'))))),
    'prefetch' => (int) env('RABBITMQ_PREFETCH', 10),
];
