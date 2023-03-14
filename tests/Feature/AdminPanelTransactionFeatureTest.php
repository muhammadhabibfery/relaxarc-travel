<?php

namespace Tests\Feature;

use App\Filament\Resources\TransactionResource;
use App\Filament\Resources\TransactionResource\Pages\ListTransactions;
use App\Filament\Resources\TransactionResource\Pages\ViewTransaction;
use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TravelPackage;
use Livewire\Livewire;

class AdminPanelTransactionFeatureTest extends TestCase
{
    private User $userAdmin;
    private User $userMember;
    private int $price;
    private Transaction $transaction;
    private array $memberData = [
        'name' => 'John Lennon',
        'username' => 'johnlennon',
        'email' => 'johnlennon@gmail.com',
        'roles' => '["MEMBER"]',
        'phone' => '12345678901',
        'address' => 'dadaikdadjadkad'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->price = 500000;
        $this->userAdmin = $this->authenticatedUser();
        $this->userMember = $this->createUser($this->memberData);
        $this->transaction = Transaction::factory()
            ->for($this->userMember)
            ->for(
                TravelPackage::factory()
                    ->state(['created_by' => $this->userAdmin->id, 'price' => $this->price])
            )
            ->hasTransactionDetails(1, ['username' => $this->userMember->username])
            ->create(['total' => $this->price]);
    }

    /** @test */
    public function transaction_menu_list_can_be_rendered()
    {
        $this->get(TransactionResource::getUrl())
            ->assertSuccessful()
            ->assertSeeText(trans('Transactions'));
    }


    /** @test */
    public function transaction_menu_list_can_show_list_of_transactions()
    {
        $transactions = $this->getTransactions();

        Livewire::test(ListTransactions::class)
            ->assertCanSeeTableRecords($transactions);
    }

    /** @test */
    public function transaction_menu_list_can_search_transactions_by_invoice_number()
    {
        $transactions = $this->getTransactions();

        Livewire::test(ListTransactions::class)
            ->searchTable($this->transaction->invoice_number)
            ->assertCanSeeTableRecords($transactions->where('invoice_number', $this->transaction->invoice_number))
            ->assertCanNotSeeTableRecords($transactions->where('invoice_number', '!==', $this->transaction->invoice_number));
    }

    /** @test */
    public function transaction_menu_list_can_filter_transaction_by_status()
    {
        $status = 'IN CART';
        $transactions = $this->getTransactions();

        Livewire::test(ListTransactions::class)
            ->assertCanSeeTableRecords($transactions)
            ->filterTable('status', $status)
            ->assertCanSeeTableRecords($transactions->where('status', $status))
            ->assertCanNotSeeTableRecords($transactions->where('status', '!==', $status));
    }

    /** @test */
    public function transaction_menu_view_can_be_rendered()
    {
        $this->get(TransactionResource::getUrl('view', ['record' => $this->transaction->invoice_number]))
            ->assertSuccessful()
            ->assertSeeText(trans('Detail Transaction', ['invoice_number' => '']));
    }

    /** @test */
    public function transaction_menu_view_can_retrieve_data_from_selected_transaction()
    {
        $data = $this->transaction;
        $data = array_merge(
            $data->toArray(),
            [
                'travel_package_id' => $this->transaction->travelPackage->title,
                'transaction_detail_count' => $this->transaction->transactionDetails()->count(),
                'detail_of_buyers' => $this->userMember->username,
                'ordered_by' => $this->userMember->name,
                'total' => currencyFormat($this->transaction->total)
            ]
        );

        Livewire::test(ViewTransaction::class, ['record' => $this->transaction->invoice_number])
            ->assertFormSet($data);
    }

    private function getTransactions()
    {
        return collect([$this->transaction, Transaction::factory()->for($this->userMember)->create(['status' => 'FAILED'])]);
    }
}
