<?php

namespace App\Http\Controllers\Api;

use App\Http\DTO\PaginationDTO;
use App\Http\DTO\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}


    /**
     * Retrieve a list of users with pagination and optional filters.
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->service->getUsers(PaginationDTO::fromRequest($request));

        return response()->json(new UserCollection($users));
    }

    /**
     * Retrieve a single user by ID.
     * 
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Create a new user with the provided data.
     * 
     * @param StoreUserRequest $request
     * 
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        // Convert the validated request data into a UserDto object.
        $data = UserDto::fromArray($request->validated());

        $user = $this->service->createUser($data);

        return response()->json(new UserResource($user), 201);
    }


    /**
     * Update an existing user's information.
     * 
     * @param UpdateUserRequest $request
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        // If a new password is provided, hash it before updating the user.
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        // Merge the current user data with the validated data to create a UserDto.
        $userDto = UserDto::fromArray(array_merge($user->toArray(), $validated));

        $updatedUser = $this->service->updateUser($user, $userDto);

        return response()->json(new UserResource($updatedUser));
    }


    /**
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->service->deleteUser($user);

        return response()->json(['message' => 'User deleted successfully']);
    }
}
