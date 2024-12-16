<?php

namespace App\Http\DTO;

class UserDto
{
    /**
     * @param string $name The name of the user.
     * @param string $email The email address of the user.
     * @param string|null $password The user's password (optional).
     * @param string|null $ip The IP address associated with the user (optional).
     * @param string|null $comment A comment or note about the user (optional).
     */
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password,
        public ?string $ip = null,
        public ?string $comment = null
    ) {}

    /**
     * Create a UserDto instance from an associative array.
     *
     * @param array $data
     * 
     * @return self
     * 
     * @throws \InvalidArgumentException If required fields (name, email) are missing.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? throw new \InvalidArgumentException('User name is required.'),
            email: $data['email'] ?? throw new \InvalidArgumentException('User email is required.'),
            password: $data['password'] ?? null,
            ip: $data['ip'] ?? null,
            comment: $data['comment'] ?? null
        );
    }

    /**
     * Convert the UserDto instance to an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'ip' => $this->ip,
            'comment' => $this->comment,
        ], fn($value) => $value !== null);
    }
}
