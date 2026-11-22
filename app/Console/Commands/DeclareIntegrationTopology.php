<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Infrastructure\Messaging\RabbitMQ\RabbitMQTopology;
use Illuminate\Console\Command;

final class DeclareIntegrationTopology extends Command
{
    protected $signature = 'integration:declare-topology';
    protected $description = 'Declare RabbitMQ exchanges, queues and bindings';

    public function handle(RabbitMQTopology $topology): int
    {
        $topology->declare();
        $this->info('RabbitMQ topology declared.');
        return self::SUCCESS;
    }
}
