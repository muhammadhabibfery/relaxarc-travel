<?php

namespace App\Filament\Resources;

use Closure;
use App\Models\User;
use Filament\Tables;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Admin Management';

    protected static ?string $recordRouteKeyName = 'username';

    public static function getBreadcrumb(): string
    {
        return trans('Manage users');
    }

    protected static function getNavigationLabel(): string
    {
        return trans('Manage users');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id', '!=', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(trans('Name'))
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, string $state) {
                                return $set('username', function () use ($state) {
                                    $state = Str::of($state)->slug('');
                                    return User::where('username', $state)->first()
                                        ? $state . rand(11, 99)
                                        : $state;
                                });
                            })
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        TextInput::make('username')
                            ->label('Username')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        TextInput::make('phone')
                            ->label(trans('Phone'))
                            ->required()
                            ->minLength(10)
                            ->maxLength(12)
                            ->unique('users', 'phone', ignoreRecord: true)
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        TextInput::make('role')
                            ->label(trans('Roles'))
                            ->default('Staff')
                            ->disabled()
                            ->hidden(fn (Page $livewire): bool => $livewire instanceof EditUser)
                            ->dehydrated(false),
                        Select::make('roles')
                            ->label(trans('Roles'))
                            ->required()
                            ->multiple()
                            ->options([
                                'SUPERADMIN' => 'Admin',
                                'ADMIN' => 'Staff',
                            ])
                            ->rules(['array', 'in:ADMIN,SUPERADMIN'])
                            ->hidden(fn (Page $livewire): bool => $livewire instanceof CreateUser)
                            ->dehydrated(fn (Page $livewire): bool => !$livewire instanceof CreateUser),
                        Textarea::make('address')
                            ->required()
                            ->label(trans('Address'))
                            ->minLength(10)
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        Radio::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'ACTIVE' => trans('ACTIVE'),
                                'NONE' => trans('NONE')
                            ])
                            ->required(fn (Page $livewire): bool => $livewire instanceof EditUser)
                            ->hidden(fn (Page $livewire): bool => $livewire instanceof CreateUser)
                            ->dehydrated(fn (Page $livewire): bool => !$livewire instanceof CreateUser),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(trans('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email'),
                BadgeColumn::make('roles')
                    ->enum([
                        'ADMIN, SUPERADMIN' => 'Admin',
                        'ADMIN' => 'Staff',
                        'MEMBER' => 'Member'
                    ])
                    ->colors([
                        'danger' => 'ADMIN, SUPERADMIN',
                        'success' => 'ADMIN',
                        'primary' => 'MEMBER'
                    ]),
                BadgeColumn::make('status')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->icons([
                        'heroicon-o-check' => 'ACTIVE',
                        'heroicon-o-x' => 'NONE'
                    ])
                    ->colors([
                        'success' => 'ACTIVE',
                        'danger' => 'NONE'
                    ])
                    ->formatStateUsing(fn (string $state) => trans($state))

            ])
            ->filters([
                SelectFilter::make('roles')
                    ->options([
                        '["ADMIN, SUPERADMIN"]' => 'Admin',
                        '["ADMIN"]' => 'Staff',
                        '["MEMBER"]' => 'Member',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'ACTIVE' => 'Active',
                        'NONE' => 'Inactive'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record:username}'),
            'edit' => Pages\EditUser::route('/{record:username}/edit'),
        ];
    }

    public static function getUser(): User
    {
        return auth()->user();
    }
}
