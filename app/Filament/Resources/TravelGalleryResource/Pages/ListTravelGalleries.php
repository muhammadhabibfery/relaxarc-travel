<?php

namespace App\Filament\Resources\TravelGalleryResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TravelGalleryResource;

class ListTravelGalleries extends ListRecords
{
    protected static string $resource = TravelGalleryResource::class;

    protected static ?string $title = 'List of travel galleries';

    public function getBreadcrumb(): ?string
    {
        return trans(self::$title);
    }

    protected function getTitle(): string
    {
        return trans(self::$title);
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }
}
