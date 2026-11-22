<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Person;

use App\Application\Handlers\V1\Person\DestroyPersonHandler;
use App\Application\Commands\V1\Person\DeletePersonCommand;
use Illuminate\Http\JsonResponse;

final class DestroyPersonController
{
    public function __invoke(int $person, DestroyPersonHandler $handler): JsonResponse
    {
        $handler->handler(DeletePersonCommand::build(['id' => $person]));

        return response()->json(null, 204);
    }
}
