<?php

namespace App\Filament\Resources\TravelPackageResource\Pages;

use App\Models\User;
use Filament\Resources\Form;
use Filament\Pages\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\TravelPackageResource;

class ViewTravelPackage extends ViewRecord
{
    protected static string $resource = TravelPackageResource::class;

    protected static ?string $title = 'Detail of travel package';

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
                ->url($this->getResource()::getUrl('index'))
        ];
    }

    public function form(Form $form): Form
    {
        return $form->make()
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(trans('Title')),
                        TextInput::make('location')
                            ->label(trans('Location')),
                        DateTimePicker::make('date_departure')
                            ->label(trans('Date of departure'))
                            ->timezone(config('app.timezone'))
                            ->displayFormat('l, j F Y H:i'),
                        TextInput::make('duration')
                            ->label(trans('Duration'))
                            ->formatStateUsing(fn (int $state): string => "$state Hari"),
                        Select::make('type')
                            ->label(trans('Type'))
                            ->options([
                                'Open Trip' => 'Open Trip',
                                'Private Group' => 'Private Group'
                            ]),
                        TextInput::make('price')
                            ->label(trans('Price'))
                            ->formatStateUsing(fn (int $state): string => currencyFormat($state)),
                        TextInput::make('featured_event')
                            ->label(trans('Feautured event')),
                        TextInput::make('language')
                            ->label(trans('Language')),
                        TextInput::make('foods')
                            ->label(trans('Foods')),
                        TextInput::make('about')
                            ->label(trans('About')),
                        TextInput::make('created_by')
                            ->label(trans('Created by'))
                            ->formatStateUsing(fn (int|null $state): string => isset($state) ? (User::find($state))->name : ''),
                        TextInput::make('updated_by')
                            ->label(trans('Updated by'))
                            ->formatStateUsing(fn (int|null $state): string => isset($state) ? (User::find($state))->name : ''),
                    ])
                    ->columns(2)
            ]);
    }
}
