<?php

namespace App\Models;

use Uru\BitrixModels\Models\UserModel;

class User extends UserModel
{
    protected static string $objectClass = BaseModel::class;
    public function getName()
    {
        return $this['NAME'];
    }
}
