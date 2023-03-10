<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminPanelDashboardTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->authenticatedUser();
    }

    /** @test */
    public function dashboard_page_can_be_rendered()
    {
        $this->get(route('filament.pages.dashboard'))
            ->assertSeeTextInOrder([
                trans('Travel Packages'),
                countOfAllTravelPackages()
            ])
            ->assertSeeTextInOrder([
                trans('Transactions'),
                countOfAllTransactions()
            ]);
    }
}
