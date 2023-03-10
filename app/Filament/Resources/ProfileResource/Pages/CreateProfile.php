<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Traits\ImageHandler;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProfileResource;

class CreateProfile extends CreateRecord
{
    use ImageHandler;

    protected static string $resource = ProfileResource::class;

    protected static bool $canCreateAnother = false;

    private string $notificatioMessage = 'Your profile updated successfully';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $data = self::$resource::getUser()->toArray();

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['new_password'])) $data['password'] = Hash::make($data['new_password']);

        if (isset($data['avatar'])) {
            if ($data['avatar'] !== self::$resource::getUser()->avatar)
                $this->deleteImage(last(explode('/', self::$resource::getUser()->avatar)), 'avatars');
        } else {
            $this->deleteImage(last(explode('/', self::$resource::getUser()->avatar)), 'avatars');
            self::$resource::getUser()->update(['avatar' => null]);
            unset($data['avatar']);
        }

        unset($data['new_password']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $sessionName = 'password_hash_' . auth()->getDefaultDriver();

        $user = self::$resource::getUser();
        if (!$user->update($data)) $this->notificationMessage = 'Failed to update the profile';

        if (session()->has($sessionName) && isset($data['password'])) {
            session()->forget($sessionName);
            session()->put([$sessionName => self::$resource::getUser()->getAuthPassword()]);
            $this->notificationMessage = 'Your profile and password updated successfully';
        }

        return $user;
    }

    public function getBreadcrumb(): string
    {
        return '';
    }

    protected function getTitle(): string
    {
        return self::$resource::getUser()->name;
    }

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Update')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('filament::resources/pages/create-record.form.actions.cancel.label'))
            ->url($this->getDefaultRoute())
            ->color('secondary');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getDefaultRoute();
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return trans($this->notificatioMessage);
    }

    private function getDefaultRoute(): string
    {
        return route('filament.pages.dashboard');
    }
}
