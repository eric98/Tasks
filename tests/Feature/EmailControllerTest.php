<?php

namespace Tests\Feature;

use App\Mail\CustomEmail;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

/**
 * Class EmailControllerTest.
 */
class EmailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Login as email manager.
     */
    protected function loginAsEmailManager()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        View::share('user', $user);
    }

    /**
     * Send an email.
     *
     * @test
     */
    public function send_an_email()
    {
        $this->loginAsEmailManager();

        Mail::fake();

        $emailto = 'sergiturbadenas@gmail.com';
        $subject = 'Prova que tal!!!';
        $body = 'Contingut del email';

        $response = $this->post('/email', [
            'emailto'     => $emailto,
            'subject'     => $subject,
            'body'        => $body,
        ]);

        Mail::assertSent(CustomEmail::class, function ($mail) use ($emailto, $subject) {
            return $mail->to[0]['address'] === $emailto && $mail->subject === $subject && $mail->subject === $subject;
        });

        $response->assertStatus(302);
    }
}
