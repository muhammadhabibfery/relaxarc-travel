<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Create user';

    public function getBreadcrumb(): string
    {
        return trans(self::$title);
    }

    protected function getTitle(): string
    {
        return trans(self::$title);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['roles'] = ["ADMIN"];
        $data['password'] = Hash::make($data['phone']);
        $data['created_by'] = self::$resource::getUser()->id;
        return $data;

        throw new \Exception(trans('Roles not available'));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return trans('User created succesfully');
    }
}
