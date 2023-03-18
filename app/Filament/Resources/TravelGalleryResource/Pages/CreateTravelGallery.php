<?php

namespace App\Filament\Resources\TravelGalleryResource\Pages;

use App\Models\TravelGallery;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TravelGalleryResource;

class CreateTravelGallery extends CreateRecord
{
    protected static string $resource = TravelGalleryResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Create Travel Gallery';

    public function getModel(): string
    {
        return TravelGallery::class;
    }

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
        $data['name'] = last(explode('/', $data['name']));
        $data['uploaded_by'] = self::$resource::getUser()->id;
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $model = app($this->getModel());
        return $model->create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return trans('Travel gallery created succesfully');
    }
}
