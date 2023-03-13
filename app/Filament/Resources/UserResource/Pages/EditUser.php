<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected static ?string $title = 'Edit user';

    public function getBreadcrumb(): string
    {
        return self::$title;
    }

    protected function getTitle(): string
    {
        return self::$title;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $adminRoles = ["ADMIN", "SUPERADMIN"];

        if (count(array_intersect($data['roles'], $adminRoles)) && in_array($data['status'], ['ACTIVE', 'NONE'])) {
            if (in_array('SUPERADMIN', $data['roles'])) $data['roles'] = $adminRoles;
            else $data['roles'] = $data['roles'];
            $data['updated_by'] = self::$resource::getUser()->id;
            return $data;
        }

        throw new \Exception(trans('Data not available'));
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(trans('Update'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return trans('User updated succesfully');
    }
}
