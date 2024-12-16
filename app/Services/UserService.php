<?php

namespace App\Services;

use App\Http\DTO\PaginationDTO;
use App\Http\DTO\UserDto;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{

    public function __construct(protected UserRepositoryInterface $repository) {}

    /**
     * Retrieve a paginated list of users based on the given pagination parameters.
     * 
     * @param PaginationDTO $pagination
     * 
     * @return LengthAwarePaginator
     */
    public function getUsers(PaginationDTO $pagination): LengthAwarePaginator
    {
        return $this->repository->paginate($pagination);
    }

    /**
     * Retrieve a user by their unique ID.
     * 
     * @param int $id
     * 
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new user using the provided data.
     * 
     * @param UserDto $data
     * 
     * @return User
     */
    public function createUser(UserDto $data): User
    {
        return $this->repository->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
            'ip' => $data->ip,
            'comment' => $data->comment
        ]);
    }

    /**
     * Update an existing user's information.
     * 
     * @param User $user The user instance to update.
     * @param UserDto $data
     * 
     * @return User
     */
    public function updateUser(User $user, UserDto $data): User
    {
        return $this->repository->update($user, $data->toArray());
    }

    /**
     * Delete a user from db.
     * 
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user): bool
    {
        return $this->repository->delete($user);
    }
}
