<?php

namespace Tests\Feature;

use App\Models\Redirect;
use Tests\TestCase;

class RedirectLogTest extends TestCase
{
    /** @test */
    public function merge_query_two_origins()
    {
        $redirect = Redirect::factory()->create([
            'url_redirect' => 'https://google.com/?utm_campaign=ads',
            'status' => 1
        ]);

        $response = $this->get(route('r.redirect', $redirect->code) . '?utm_source=facebook');

        $url = explode('?', $redirect->url_redirect)[0];

        $response->assertRedirect($url . '?utm_campaign=ads&utm_source=facebook');
    }

    /** @test */
    public function merge_query_preference_request()
    {
        $redirect = Redirect::factory()->create([
            'url_redirect' => 'https://youtube.com/?utm_source=facebook&utm_campaign=ads',
            'status' => 1
        ]);

        $response = $this->get(route('r.redirect', $redirect->code) . '?utm_source=instagram');

        $url = explode('?', $redirect->url_redirect)[0];

        $response->assertRedirect($url . '?utm_source=instagram&utm_campaign=ads');
    }

    /** @test */
    public function merge_ignore_null_key()
    {
        $redirect = Redirect::factory()->create([
            'url_redirect' => 'https://dropbox.com/?utm_source=facebook',
            'status' => 1
        ]);

        $response = $this->get(route('r.redirect', $redirect->code) . '?utm_source=&utm_campaign=test');

        $url = explode('?', $redirect->url_redirect)[0];

        $response->assertRedirect($url . '?utm_source=facebook&utm_campaign=test');
    }
}
