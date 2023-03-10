<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    public function getBreadcrumb(): string
    {
        return '';
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }
}
