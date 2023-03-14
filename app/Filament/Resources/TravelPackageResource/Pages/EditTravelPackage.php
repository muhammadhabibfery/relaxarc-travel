<?php

namespace App\Filament\Resources\TravelPackageResource\Pages;

use Carbon\Carbon;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TravelPackageResource;

class EditTravelPackage extends EditRecord
{
    protected static string $resource = TravelPackageResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected static ?string $title = 'Edit travel package';

    public function getBreadcrumb(): string
    {
        return trans('Edit travel package');
    }

    protected function getTitle(): string
    {
        return trans('Edit travel package');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['date_completion'] = Carbon::parse($data['date_departure'], config('app.timezone'))->addDays($data['duration']);
        $data['updated_by'] = self::$resource::getUser()->id;
        return $data;

        throw new \Exception(trans('Roles not available'));
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
        return trans('Travel package updated succesfully');
    }
}
