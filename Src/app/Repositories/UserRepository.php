<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll($perPage = 10)
    {
        return User::paginate($perPage);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function getCustomer(User $user)
    {
        return $user->customer;
    }
}