<?php

namespace App\Http\DTO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaginationDTO
{
    /**
     * @param string|null $order Sorting order, either 'asc' or 'desc'.
     * @param string|null $search Optional search query string.
     * @param string|null $sortBy Field to sort by, e.g., 'created_at'.
     * @param int|null $page Current page number.
     * @param int|null $perPage Number of items per page.
     */
    public function __construct(
        public ?string $order = null,
        public ?string $search = null,
        public ?string $sortBy = null,
        public ?int $page = 1,
        public ?int $perPage = 15,
    ) {}

    /**
     * Create an instance of PaginationDTO from a request object.
     * 
     * @param Request $request
     * 
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $rules = [
            'order' => 'nullable|in:asc,desc',
            'search' => 'nullable|string|max:255',
            'sortBy' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
            'perPage' => 'nullable|integer|min:1|max:100',
        ];

        $validatedData = Validator::make($request->all(), $rules)->validate();

        return new self(
            order: $validatedData['order'] ?? 'asc',
            search: $validatedData['search'] ?? null,
            sortBy: $validatedData['sortBy'] ?? 'created_at',
            page: $validatedData['page'] ?? 1,
            perPage: $validatedData['perPage'] ?? 15,
        );
    }
}
