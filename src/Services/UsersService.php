<?php

namespace App\Services;

use App\Models\User;

class UsersService
{
    private User $user;

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function createUser($id): self
    {
        $user = new User($id, ['NAME' => 'John Doe', 'REG_DATE' => (new \DateTime())->format('Y-m-d H:i:s')]);

        return $this->setUser($user);
    }
}
