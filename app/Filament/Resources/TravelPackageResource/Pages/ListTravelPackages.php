<?php

namespace App\Filament\Resources\TravelPackageResource\Pages;

use App\Filament\Resources\TravelPackageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTravelPackages extends ListRecords
{
    protected static string $resource = TravelPackageResource::class;

    protected static ?string $title = 'List of travel packages';

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
