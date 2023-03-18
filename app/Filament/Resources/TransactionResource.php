<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Transaction;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\TransactionResource\Pages;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationGroup = 'Staff Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordRouteKeyName = 'invoice_number';

    public static function getBreadcrumb(): string
    {
        return trans('Transactions');
    }

    protected static function getNavigationLabel(): string
    {
        return trans('Transactions');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label(trans('Invoice number'))
                    ->searchable(),
                TextColumn::make('travelPackage.title')
                    ->label(trans('Travel Packages'))
                    ->searchable(),
                TextColumn::make('total')
                    ->formatStateUsing(fn (int $state): string => currencyFormat($state)),
                BadgeColumn::make('status')
                    ->enum([
                        'SUCCESS' => 'Success',
                        'FAILED' => 'Failed',
                        'PENDING' => 'Pending',
                        'IN CART' => 'In Cart'
                    ])
                    ->colors([
                        'success' => 'SUCCESS',
                        'danger' => 'FAILED',
                        'primary' => 'PENDING',
                        'secondary' => 'IN CART'
                    ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'SUCCESS' => 'Success',
                        'FAILED' => 'Failed',
                        'PENDING' => 'Pending',
                        'IN CART' => 'In Cart'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'view' => Pages\ViewTransaction::route('/{record:invoice_number}'),
        ];
    }
}
