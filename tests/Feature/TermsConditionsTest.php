<?php

namespace Tests\Feature;

use Tests\TestCase;

class TermsConditionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function terms_and_conditions_page_can_be_rendered()
    {
        $res = $this->get(route('terms-conditions'));

        $res->assertViewIs('pages.frontend.terms-conditions')
            ->assertSeeText('Syarat Ketentuan');
    }
}
