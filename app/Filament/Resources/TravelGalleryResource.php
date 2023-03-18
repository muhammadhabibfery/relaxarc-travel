<?php

namespace App\Filament\Resources;

use Closure;
use App\Models\User;
use Filament\Tables;
use App\Traits\ImageHandler;
use Filament\Resources\Form;
use App\Models\TravelPackage;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TravelGalleryResource\Pages;
use Filament\Notifications\Notification;

class TravelGalleryResource extends Resource
{
    use ImageHandler;

    protected static ?string $model = TravelPackage::class;

    protected static ?string $slug = 'travel-galleries';

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Staff Management';

    protected static ?string $pluralModelLabel = 'Gallery travel';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordRouteKeyName = 'slug';

    protected static string $directory = 'travel-galleries';

    private static int $maxItems = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('date_departure', '>', now(config('app.timezone')))
            ->has('travelGalleries')
            ->withCount('travelGalleries');
    }

    public static function getBreadcrumb(): string
    {
        return trans('Travel Galleries');
    }

    protected static function getNavigationLabel(): string
    {
        return trans('Travel Galleries');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('travel_package_id')
                            ->label(trans('Travel Packages'))
                            ->options(
                                fn () => app(self::$model)->where('date_departure', '>', now(config('app.timezone')))->pluck('title', 'id')
                            )
                            ->required()
                            ->exists('travel_packages', 'id'),
                        FileUpload::make('name')
                            ->label(trans('Choose Image'))
                            ->image()
                            ->maxSize(2500)
                            ->required()
                            ->rules([
                                function (Closure $get, Closure $set) {
                                    return function (string $attribute, $value, Closure $fail) use ($get, $set) {
                                        $model = app(self::$model)->find($get('travel_package_id'));

                                        if (is_null($model)) $fail(trans('Travel packages not available'));

                                        $travelGalleries = $model->travelGalleries()->count();

                                        if ($travelGalleries >= self::$maxItems) {
                                            $file = $value;
                                            $filePath = last(explode('\\', $file->getPath()));
                                            $fileName = $file->getFileName();

                                            self::deleteImage($fileName, $filePath);

                                            $set('name', null);

                                            $fail(trans('The amount of travel galleries has exceeded capacity (max :items items)', ['items' => self::$maxItems]));
                                        }
                                    };
                                }
                            ])
                            ->directory('travel-galleries')
                            ->getUploadedFileNameForStorageUsing(
                                fn (TemporaryUploadedFile $file): string|null => self::getFileName($file->getClientOriginalName())
                            )
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(trans('Travel Packages'))
                    ->searchable(),
                TextColumn::make('travel_galleries_count')
                    ->label(trans('Total image'))
                    ->counts('travelGalleries')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('delete')
                    ->label(trans('Delete'))
                    ->icon('heroicon-s-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(trans('Delete'))
                    ->modalSubheading(trans('Are you sure want to delete these travel galleries ?'))
                    ->action(function (Model $record) {
                        $fileNames = $record->travelGalleries
                            ->pluck('name');
                        $result = $record->travelGalleries()
                            ->delete();
                        if ($result) {
                            $fileNames->each(fn ($item) => self::deleteImage($item, self::$directory));
                            Notification::make()
                                ->title(trans('Travel galleries successfully deleted'))
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title(trans('Failed to delete travel galleries'))
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTravelGalleries::route('/'),
            'create' => Pages\CreateTravelGallery::route('/create'),
            'view' => Pages\ViewTravelGallery::route('/{record:slug}')
        ];
    }

    public static function getMaxItems(): int
    {
        return self::$maxItems;
    }

    public static function getUser(): User
    {
        return auth()->user();
    }
}
