<?php

namespace App\Domain\V1\Shared\Pagination;

/**
 * @template T
 */
final readonly class PaginatedResult
{
    /**
     * @param array<T> $items
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $currentPage,
        public int $perPage,
        public int $lastPage,
    ) {
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage;
    }
}
