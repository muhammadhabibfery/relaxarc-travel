<?php

namespace App\Filament\Resources;

use Closure;
use App\Models\User;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\ProfileResource\Pages;
use App\Traits\ImageHandler;
use Filament\Forms\Components\FileUpload;
use Livewire\TemporaryUploadedFile;

class ProfileResource extends Resource
{
    use ImageHandler;

    protected static ?string $model = User::class;

    protected static ?string $pluralModelLabel = 'Profile';

    protected static ?string $slug = 'profile';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile')
                    ->description('Update profile form')
                    ->schema([
                        TextInput::make('name')
                            ->label(trans('Name'))
                            ->nullable()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                return $set('username', function () use ($state) {
                                    $usernameExists = User::where('username', $state)->first();
                                    $state = Str::of($state)->slug('');
                                    return $usernameExists && $usernameExists !== self::getUser()->username
                                        ? $state . rand(11, 99)
                                        : $state;
                                });
                            }),
                        TextInput::make('username')
                            ->label('Username')
                            ->maxLength(255)
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->unique('users', 'email', self::getUser()),
                        TextInput::make('phone')
                            ->label(trans('Phone'))
                            ->minLength(10)
                            ->maxLength(12)
                            ->unique('users', 'phone', self::getUser()),
                        TextInput::make('address')
                            ->label(trans('Address')),
                        FileUpload::make('avatar')
                            ->label(trans('Choose profile picture'))
                            ->image()
                            ->maxSize(2500)
                            ->directory('avatars')
                            ->getUploadedFileNameForStorageUsing(
                                fn (TemporaryUploadedFile $file): string => self::getFileName($file->getClientOriginalName())
                            )
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Password')
                    ->description(trans('Change password form'))
                    ->schema([
                        TextInput::make('current_password')
                            ->label(trans('Current password'))
                            ->password()
                            ->nullable()
                            ->rules(['password'])
                            ->dehydrated(false),
                        TextInput::make('new_password')
                            ->label(trans('New password'))
                            ->password()
                            ->requiredWith('current_password')
                            ->different('current_password')
                            ->minLength(5)
                            ->confirmed(),
                        TextInput::make('new_password_confirmation')
                            ->label(trans('Password Confimation'))
                            ->password()
                            ->requiredWith('new_password')
                            ->dehydrated(false)
                    ])
                    ->collapsible()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateProfile::route('/'),
        ];
    }

    public static function getUser(): User
    {
        return auth()->user();
    }

    public static function shouldIgnorePolicies(): bool
    {
        return checkRoles(["ADMIN", 1], self::getUser()->roles);
    }
}
