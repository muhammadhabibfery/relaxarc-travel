<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Transaction;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationGroup = 'Staff Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordRouteKeyName = 'invoice_number';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
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
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        // dd(Transaction::where('invoice_number', 'RelaxArc-09923kvPbM0jMlNRXqNqk')->first());
        return [
            'index' => Pages\ListTransactions::route('/'),
            'view' => Pages\ViewTransaction::route('/{record:invoice_number}'),
            // 'create' => Pages\CreateTransaction::route('/create'),
            // 'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
