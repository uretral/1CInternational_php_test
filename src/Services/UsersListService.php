<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UsersListService
{
    public function getUsers(): Collection
    {
        return User::GetList();
    }

}
