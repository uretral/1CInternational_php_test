<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Uru\BitrixModels\Models\UserModel;

class User extends UserModel
{
    protected static string $objectClass = BaseModel::class;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this['NAME'];
    }

    // перезаписанный метод возвращающий пользователей из БД
    public static function GetList(): Collection
    {
        return new Collection(
            [
                new User(1, ['NAME' => 'John Doe']),
                new User(2, ['NAME' => 'Alan M']),
                new User(2, ['NAME' => 'Mike M']),
            ]
        );
    }
}
