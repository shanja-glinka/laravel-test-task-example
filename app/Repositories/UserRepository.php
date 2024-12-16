<?php

namespace App\Repositories;

use App\Http\DTO\PaginationDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param null|PaginationDTO $pagination
     * 
     * @return LengthAwarePaginator
     */
    public function paginate(?PaginationDTO $pagination = null): LengthAwarePaginator
    {
        $pagination = $pagination ?? new PaginationDTO();

        $query = User::query();

        if ($pagination->search) {
            $query->where('name', 'like', '%' . $pagination->search . '%');
        }

        if ($pagination->sortBy) {
            $query->orderBy($pagination->sortBy, $pagination->order ?? 'asc');
        }

        return $query->paginate(perPage: $pagination->perPage ?? 15, page: $pagination->page ?? 1);
    }

    /**
     * @param int $id
     * 
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * @param array $data
     * 
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param User $user
     * @param array $data
     * 
     * @return User
     */
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    /**
     * @param User $user
     * 
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
