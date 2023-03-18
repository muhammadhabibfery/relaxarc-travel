<?php

namespace App\Filament\Resources\TravelGalleryResource\Pages;

use App\Models\TravelGallery;
use Filament\Resources\Table;
use Filament\Pages\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TravelGalleryResource;

class ViewTravelGallery extends ListRecords
{
    protected static string $resource = TravelGalleryResource::class;

    protected string $directory = 'travel-galleries';

    protected static ?string $title = 'List of travel galleries';

    public function getModel(): string
    {
        return TravelGallery::class;
    }

    protected function getTableQuery(): Builder
    {
        $uri = last(explode('/', request()->path()));

        return app($this->getModel())
            ->whereHas(
                'travelPackage',
                fn (Builder $query) => $query->where('slug', $uri)
            );
    }

    public function getBreadcrumb(): string
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
            Action::make('back')
                ->color('secondary')
                ->url($this->getResource()::getUrl('index')),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('slug')
                ->label(trans('Name')),
            ImageColumn::make('name')
                ->label(trans('Image'))
                ->getStateUsing(fn (Model $record) => "{$this->directory}/{$record->name}"),
        ]);
    }
}
