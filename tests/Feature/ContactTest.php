<?php

namespace Tests\Feature;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function contact_page_can_be_rendered()
    {
        $res = $this->get(route('contact'));

        $res->assertViewIs('pages.frontend.contact')
            ->assertSeeText('Kontak Kami');
    }

    /** @test */
    public function the_fields_should_be_follow_the_rules()
    {
        $this->withExceptionHandling();
        $data = ['email' => 'abc', 'phone' => '12345'];

        $res = $this->post(route('contact.send-mail'), $data);

        $res->assertInvalid(['name', 'email', 'phone', 'message']);
    }

    /** @test */
    public function Contact_page_can_send_email()
    {
        Mail::fake();
        $data = ['name' => 'John Lennon', 'email' => 'johnlennon@gmail.com', 'phone' => '12345678901', 'message' => 'akdjklajddklawdjkawdjlaw'];

        $res = $this->post(route('contact.send-mail'), $data);

        Mail::assertQueued(ContactMail::class);

        $res->assertSessionHas('status');
    }
}
