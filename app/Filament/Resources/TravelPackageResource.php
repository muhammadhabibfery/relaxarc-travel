<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\TravelPackage;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TravelPackageResource\Pages;

class TravelPackageResource extends Resource
{
    protected static ?string $model = TravelPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Staff Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordRouteKeyName = 'slug';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getBreadcrumb(): string
    {
        return trans('Travel Packages');
    }

    protected static function getNavigationLabel(): string
    {
        return trans('Travel Packages');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(trans('Title'))
                            ->required()
                            ->maxLength(55)
                            ->unique('travel_packages', 'title', ignoreRecord: true),
                        TextInput::make('location')
                            ->label(trans('Location'))
                            ->required()
                            ->maxLength(75),
                        TextInput::make('featured_event')
                            ->label(trans('Feautured event'))
                            ->helperText(trans("*Use komma ',' to input some data", ['data' => trans('Feautured event')]))
                            ->required()
                            ->maxLength(150),
                        TextInput::make('language')
                            ->label(trans('Language'))
                            ->helperText(trans("*Use komma ',' to input some data", ['data' => trans('Language')]))
                            ->required()
                            ->maxLength(250),
                        TextInput::make('foods')
                            ->label(trans('Foods'))
                            ->helperText(trans("*Use komma ',' to input some data", ['data' => trans('Foods')]))
                            ->required()
                            ->maxLength(150),
                        DateTimePicker::make('date_departure')
                            ->label(trans('Date of departure'))
                            ->placeholder(trans("Select date & time of departure"))
                            ->timezone(config('app.timezone'))
                            ->withoutSeconds()
                            ->required()
                            ->format('Y-m-d H:i')
                            ->displayFormat('l, j F Y H:i')
                            ->minDate(now(config('app.timezone'))->addDay()),
                        TextInput::make('duration')
                            ->label(trans('Duration'))
                            ->helperText(trans('*Maximum 14 days'))
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(14)
                            ->suffix('Hari'),
                        TextInput::make('about')
                            ->label(trans('About'))
                            ->required()
                            ->maxLength(250),
                        Select::make('type')
                            ->label(trans('Type'))
                            ->required()
                            ->in([
                                'Open Trip' => 'Open Trip',
                                'Private Group' => 'Private Group'
                            ])
                            ->options([
                                'Open Trip' => 'Open Trip',
                                'Private Group' => 'Private Group'
                            ]),
                        TextInput::make('price')
                            ->label(trans('Price'))
                            ->required()
                            ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'Rp. ', thousandsSeparator: '.', decimalPlaces: 3, isSigned: false))
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(trans('Title'))
                    ->searchable(),
                TextColumn::make('location')
                    ->label(trans('Location'))
                    ->searchable(),
                TextColumn::make('date_departure')
                    ->label(trans('Date of departure'))
                    ->formatStateUsing(fn (string $state): string => transformDateFormat($state, 'l, j F Y H:i')),
                TextColumn::make('duration')
                    ->label(trans('Duration'))
                    ->formatStateUsing(fn (int $state): string => formatTravelPackageDuration($state, app()->getLocale())),
                TextColumn::make('price')
                    ->label(trans('Price'))
                    ->formatStateUsing(fn (int $state): string => currencyFormat($state)),
                BadgeColumn::make('date_departure_status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => trans($state))
                    ->colors([
                        'success' => 'AVAILABLE',
                        'primary' => 'ONGOING',
                        'danger' => 'EXPIRED'
                    ]),
            ])
            ->filters([
                Filter::make('status')
                    ->label('Status')
                    ->form([
                        Select::make('status')
                            ->options([
                                '>' => trans('AVAILABLE'),
                                '!' => trans('ONGOING'),
                                '<' => trans('EXPIRED')
                            ])
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['status'],
                            fn (Builder $query, string $value): Builder => $query->withStatus($value)
                        );
                    }),
                Tables\Filters\TrashedFilter::make()
                    ->hidden(fn (): bool => !setPermissions(["SUPERADMIN", 1], self::getUser())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle(trans('Travel package deleted succesfully')),
                Tables\Actions\RestoreAction::make()
                    ->successNotificationTitle(trans('Travel package restored succesfully')),
                Tables\Actions\ForceDeleteAction::make()
                    ->successNotificationTitle(trans('Travel package succesfully deleted permanently')),

            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTravelPackages::route('/'),
            'create' => Pages\CreateTravelPackage::route('/create'),
            'view' => Pages\ViewTravelPackage::route('/{record:slug}'),
            'edit' => Pages\EditTravelPackage::route('/{record:slug}/edit'),
        ];
    }

    public static function getUser(): User
    {
        return auth()->user();
    }
}
