<?php

namespace App\Repositories\Contracts;

use App\Http\DTO\PaginationDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Retrieve a paginated list of users based on the given pagination parameters.
     * 
     * @param null|PaginationDTO $pagination Optional DTO containing pagination parameters.
     * 
     * @return LengthAwarePaginator Paginated list of users.
     */
    public function paginate(?PaginationDTO $pagination = null): LengthAwarePaginator;

    /**
     * Find a user by their unique ID.
     * 
     * @param int $id The unique identifier of the user.
     * 
     * @return User|null The user instance if found, or null if not.
     */
    public function findById(int $id): ?User;

    /**
     * Create a new user with the provided data.
     * 
     * @param array $data Array containing user information.
     * 
     * @return User The created user instance.
     */
    public function create(array $data): User;

    /**
     * Update an existing user's information.
     * 
     * @param User $user The user instance to update.
     * @param array $data Array containing updated user information.
     * 
     * @return User The updated user instance.
     */
    public function update(User $user, array $data): User;

    /**
     * Delete a user from the system.
     * 
     * @param User $user The user instance to delete.
     * 
     * @return bool True if the user was successfully deleted, false otherwise.
     */
    public function delete(User $user): bool;
}
