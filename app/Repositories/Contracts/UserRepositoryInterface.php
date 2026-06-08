<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data): User;

    /**
     * Find a user by their email address.
     *
     * @param  string  $email
     * @return \App\Models\User|null
     */
    public function findByEmail(string $email): ?User;
}