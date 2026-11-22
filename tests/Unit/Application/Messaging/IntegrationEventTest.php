<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Messaging;

use App\Application\Messaging\IntegrationEvent;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class IntegrationEventTest extends TestCase
{
    public function testRoundTripPreservesEnvelope(): void
    {
        $event = new IntegrationEvent(
            'c0b7b5f0-8718-4f77-8c45-ef5f791b224d',
            'customer.created',
            1,
            '2026-11-22T16:00:00Z',
            'work_order',
            '15',
            ['customer_id' => 44],
        );
        $restored = IntegrationEvent::fromJson($event->toJson());
        $this->assertSame($event->toJson(), $restored->toJson());
        $this->assertSame('work_order.customer.created.v1', $restored->routingKey());
    }

    public static function invalidIds(): array
    {
        return [[''], ['not-a-uuid']];
    }

    #[DataProvider('invalidIds')]
    public function testRejectsInvalidEventId(string $id): void
    {
        $this->expectException(InvalidArgumentException::class);
        new IntegrationEvent($id, 'customer.created', 1, '2026-11-22T16:00:00Z', 'work_order', '15', []);
    }
}
