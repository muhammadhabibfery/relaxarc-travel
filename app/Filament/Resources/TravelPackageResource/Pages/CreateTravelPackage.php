<?php

namespace App\Filament\Resources\TravelPackageResource\Pages;

use App\Filament\Resources\TravelPackageResource;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateTravelPackage extends CreateRecord
{
    protected static string $resource = TravelPackageResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Create Travel Package';

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
        $data['date_completion'] = Carbon::parse($data['date_departure'], config('app.timezone'))->addDays($data['duration']);
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
        return trans('Travel package created succesfully');
    }
}
