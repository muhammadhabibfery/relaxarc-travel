<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Resources\Form;
use Filament\Pages\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Detail of user';

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['roles'] = count($data['roles']) > 1
            ? ucfirst(strtolower(head($data['roles'])))
            : 'STAFF';
        return $data;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Card::make()
                ->schema([
                    TextInput::make('name'),
                    TextInput::make('username'),
                    TextInput::make('email'),
                    TextInput::make('phone'),
                    TextInput::make('roles'),
                    Textarea::make('address'),
                    TextInput::make('status'),
                    TextInput::make('created_by')
                        ->formatStateUsing(fn (int|null $state): string => isset($state) ? (User::find($state))->name : ''),
                    TextInput::make('updated_by')
                        ->formatStateUsing(fn (int|null $state): string => isset($state) ? (User::find($state))->name : ''),
                ])
        ]);
    }
}
