<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TravelGallery;
use App\Models\TravelPackage;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class CheckoutTest extends TestCase
{
    private User $userAdmin;
    private User $userMember;
    private int $price;
    private Transaction $transaction;
    private string $directory = 'travel-galleries';
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
        Storage::fake($this->directory);

        $this->price = 500000;
        $this->userAdmin = $this->createUser();
        $this->userMember = $this->authenticatedUser($this->memberData);
        $this->transaction = Transaction::factory()
            ->for($this->userMember)
            ->for(
                TravelPackage::factory()
                    ->state(['created_by' => $this->userAdmin->id, 'price' => $this->price])
                    ->hasTravelGalleries(1)
            )
            ->hasTransactionDetails(1, ['username' => $this->userMember->username])
            ->create(['status' => 'SUCCESS', 'total' => $this->price]);
        $this->deleteDirectory($this->directory, TravelGallery::first()->name);
    }

    /** @test */
    public function checkout_page_can_be_rendered()
    {
        $price = 'Rp. ' . number_format(TravelPackage::first()->price, 0, '.', '.');

        $res = $this->get(route('checkout.index', $this->transaction->invoice_number));

        $res->assertViewIs('pages.frontend.checkout')
            ->assertSeeText('Who is Going?')
            ->assertSeeText(TransactionDetail::first()->username)
            ->assertSeeText(TransactionDetail::count() . ' orang')
            ->assertSeeText($price);
    }

    /** @test */
    public function user_can_checkout_the_travel_package()
    {
        $travelPackage = $this->createTravelPackage(['created_by' => $this->userAdmin->id]);

        $res = $this->post(route('checkout.proccess', $travelPackage->slug));
        $transaction = Transaction::all()->last();

        $res->assertRedirect(route('checkout.index', $transaction->invoice_number));
        $this->assertDatabaseCount('transactions', 2)
            ->assertDatabaseCount('transaction_details', 2)
            ->assertDatabaseHas('transactions', $transaction->only('status'));
    }

    /** @test */
    public function user_can_cancel_the_travel_package_checkout()
    {
        $slug = TravelPackage::first()->slug;

        $res = $this->delete(route('checkout.cancel', $this->transaction->invoice_number));

        $res->assertRedirect(route('travel-packages.front.detail', $slug));
        $this->assertDatabaseCount('transactions', 0)
            ->assertDatabaseCount('transaction_details', 0);
    }

    /** @test */
    public function add_other_member_fields_should_follow_the_rules()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('checkout.create', $this->transaction->invoice_number), ['username' => $this->userMember->username]);

        $res->assertInvalid('username');
    }

    /** @test */
    public function user_can_add_other_member_in_checkout_page()
    {
        $otherMember = $this->otherMember();

        $this->post(route('checkout.create', $this->transaction->invoice_number), ['username' => $otherMember->username]);

        $this->assertDatabaseHas('transaction_details', $otherMember->only(['username']))
            ->assertDatabaseCount('transaction_details', 2)
            ->assertDatabaseHas('transactions', ['total' => $this->totalPrice()]);
    }

    /** @test */
    public function user_can_remove_other_member_in_checkout_page()
    {
        $otherMember = $this->otherMember();
        $this->transaction->transactionDetails()
            ->create(['username' => $otherMember->username]);
        $this->transaction->update([
            'total' => $this->totalPrice()
        ]);

        $this->delete(route('checkout.remove', [$this->transaction->invoice_number, $otherMember->username]));

        $this->assertDatabaseMissing('transaction_details', $otherMember->only(['username']))
            ->assertDatabaseCount('transaction_details', 1)
            ->assertDatabaseHas('transactions', ['total' => $this->totalPrice()]);
    }

    private function otherMember(): User
    {
        $data =
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'johndoe@gmail.com',
                'roles' => '["MEMBER"]',
                'phone' => '12345678900',
                'address' => 'dadaikdadjadkads'
            ];

        return $this->createUser($data);
    }

    private function totalPrice(): int
    {
        return (int) TravelPackage::first()->price * TransactionDetail::count();
    }
}
