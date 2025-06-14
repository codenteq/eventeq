<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\Role;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::query()->where('email', $data['email'])->first();

        $data['role'] = Role::Admin->value;

        if ($user) {
            $user->update($data);
            return $user;
        }

        return static::getModel()::create($data);
    }
}
