<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TransactionResource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('back')
                ->label(trans('Back'))
                ->color('secondary')
                ->url($this->getResource()::getUrl())
        ];
    }

    protected function getTitle(): string
    {
        return trans('Detail Transaction', ['invoice_number' => '']);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('invoice_number')
                            ->label(trans('Invoice number')),
                        TextInput::make('travel_package_id')
                            ->label(trans('Travel Packages'))
                            ->formatStateUsing(fn (): string => $this->record->travelPackage->title),
                        TextInput::make('status'),
                        TextInput::make('transaction_detail_count')
                            ->label(trans('Number of buyers'))
                            ->formatStateUsing(fn (): int => $this->record->transactionDetails()->count()),
                        TextInput::make('detail_of_buyers')
                            ->label(trans('Detail of buyers'))
                            ->formatStateUsing(fn (): string => implode(', ', $this->record->transactionDetails->map(fn ($item) => $item->username)->toArray())),
                        TextInput::make('total')
                            ->formatStateUsing(fn (int $state): string => currencyFormat($state)),
                        TextInput::make('ordered_by')
                            ->label(trans('Ordered by :Name', ['Name' => '']))
                            ->formatStateUsing(fn (): string => $this->record->user->name)
                    ])
            ]);
    }
}
