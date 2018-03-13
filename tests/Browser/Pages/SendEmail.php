<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class SendEmail extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/email';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser
            ->assertPathIs($this->url())
            ->assertTitleContains('Send email')
//            ->pause(50000)
            ->assertSeeIn('.box-title', 'Send Email')
            ->assertMissing('.alert-success');
        //->assertSourceHas($code)
            //        $browser->assertVisible($selector)	Assert the element matching the given selector is visible.
    }

    /**
     * Send email.
     */
    public function sendEmail(Browser $browser)
    {
        $browser
            ->type('emailto', 'ericgarcia@iesebre.com')
            ->type('subject', 'Email de prova');
        // Instead use Javascript to set value
        $browser->script("$('textarea[name=\"body\"').html('Contingut del correu...');");
        $browser->pause(500)->press('Send');
    }

    /**
     * Assert see success.
     */
    public function assertSeeSuccess(Browser $browser)
    {
        $browser->assertVisible('.alert-success')->assertSeeIn('.alert-success', 'Your email has been successfully send!');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
