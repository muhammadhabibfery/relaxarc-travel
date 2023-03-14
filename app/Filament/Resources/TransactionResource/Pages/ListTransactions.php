<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected static ?string $title = 'List of transactions';

    public function getBreadcrumb(): ?string
    {
        return trans(self::$title);
    }

    protected function getTitle(): string
    {
        return trans(self::$title);
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }
}
