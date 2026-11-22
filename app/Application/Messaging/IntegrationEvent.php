<?php

declare(strict_types=1);

namespace App\Application\Messaging;

use DateTimeImmutable;
use InvalidArgumentException;
use Illuminate\Support\Str;

final readonly class IntegrationEvent
{
    public function __construct(
        public string $eventId,
        public string $eventType,
        public int $eventVersion,
        public string $occurredAt,
        public string $producer,
        public string $tenantId,
        public array $payload,
        public ?string $correlationId = null,
    ) {
        if (!Str::isUuid($eventId) || $eventVersion !== 1 || $producer === '' || $tenantId === '' || $eventType === '') {
            throw new InvalidArgumentException('Invalid integration event envelope.');
        }
        try {
            new DateTimeImmutable($occurredAt);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid occurred_at timestamp.', previous: $e);
        }
    }

    public static function customer(string $action, string $tenantId, array $payload, string $producer, ?string $correlationId = null): self
    {
        if (!in_array($action, ['created', 'updated'], true)) {
            throw new InvalidArgumentException('Unsupported customer action.');
        }

        return new self(
            eventId: (string) Str::uuid(),
            eventType: "customer.{$action}",
            eventVersion: 1,
            occurredAt: now()->toIso8601String(),
            producer: $producer,
            tenantId: $tenantId,
            payload: $payload,
            correlationId: $correlationId,
        );
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new InvalidArgumentException('Event must be a JSON object.');
        }

        return new self(
            eventId: (string) ($data['event_id'] ?? ''),
            eventType: (string) ($data['event_type'] ?? ''),
            eventVersion: (int) ($data['event_version'] ?? 0),
            occurredAt: (string) ($data['occurred_at'] ?? ''),
            producer: (string) ($data['producer'] ?? ''),
            tenantId: (string) ($data['tenant_id'] ?? ''),
            payload: is_array($data['payload'] ?? null) ? $data['payload'] : [],
            correlationId: isset($data['correlation_id']) ? (string) $data['correlation_id'] : null,
        );
    }

    public function routingKey(): string
    {
        return "{$this->producer}.{$this->eventType}.v{$this->eventVersion}";
    }

    public function toJson(): string
    {
        return json_encode([
            'event_id' => $this->eventId,
            'event_type' => $this->eventType,
            'event_version' => $this->eventVersion,
            'occurred_at' => $this->occurredAt,
            'producer' => $this->producer,
            'tenant_id' => $this->tenantId,
            'correlation_id' => $this->correlationId,
            'payload' => $this->payload,
        ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
