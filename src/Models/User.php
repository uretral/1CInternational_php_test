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

    public function getRegisterDate(): string
    {
        return $this['REG_DATE'];
    }

    // перезаписанный метод возвращающий пользователей из БД
    public static function GetList(): Collection
    {
        return new Collection(
            [
                new User(1, ['NAME' => 'John Doe', 'REG_DATE' => '2023-12-01 12:12:12']),
                new User(2, ['NAME' => 'Alan M', 'REG_DATE' => '2023-12-02 12:12:10']),
                new User(3, ['NAME' => 'Mike M', 'REG_DATE' => '2023-11-01 12:12:09']),
            ]
        );
    }
}
