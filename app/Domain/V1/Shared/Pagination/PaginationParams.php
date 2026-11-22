<?php

namespace App\Domain\V1\Shared\Pagination;

use InvalidArgumentException;

final readonly class PaginationParams
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 15,
    ) {
        if ($page < 1) {
            throw new InvalidArgumentException(
                'A página deve ser maior que zero.'
            );
        }

        if ($perPage < 1 || $perPage > 100) {
            throw new InvalidArgumentException(
                'O limite deve estar entre 1 e 100.'
            );
        }
    }
}
