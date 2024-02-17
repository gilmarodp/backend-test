<?php

namespace Tests\Feature;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectStatTest extends TestCase
{
    /** @test */
    public function count_unique_ip_address_to_many_requests_only_one_ip_address()
    {
        $redirect = Redirect::factory()->create();

        RedirectLog::factory()->count(rand(10, 99))->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->get(route('api.redirects.stats', $redirect->code));

        $response->assertJson(['unique' => 1]);
    }

    /** @test */
    public function count_headers_refer()
    {
        $redirect = Redirect::factory()->create();

        RedirectLog::factory()->count(2)->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
            'header_refer' => 'https://test1.com'
        ]);

        RedirectLog::factory()->count(4)->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
            'header_refer' => 'https://test2.com'
        ]);

        RedirectLog::factory()->count(7)->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
            'header_refer' => 'https://test3.com'
        ]);

        $response = $this->get(route('api.redirects.stats', $redirect->code));

        $response->assertJson(['top_referrers' => [
            [
                'header_refer' => 'https://test3.com',
                'count' => 7,
            ],
            [
                'header_refer' => 'https://test2.com',
                'count' => 4,
            ],
            [
                'header_refer' => 'https://test1.com',
                'count' => 2,
            ],
        ]]);
    }

    /** @test */
    public function count_until_ten_days_ago()
    {
        $redirect = Redirect::factory()->create();

        RedirectLog::factory()->count(10)->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
        ]);

        RedirectLog::factory()->count(2)->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
            'accessed_at' => now()->addDays(-11)->format('Y-m-d H:i:s'),
        ]);

        $response = $this->get(route('api.redirects.stats', $redirect->code));

        $response->assertJson([
            'total' => 12,
            'until_ten_days_ago' => [
                'total' => 10,
            ],
        ]);
    }

    /** @test */
    public function count_until_ten_days_ago_without_access()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->get(route('api.redirects.stats', $redirect->code));

        $response->assertJson([
            'total' => 0,
            'until_ten_days_ago' => [
                'total' => 0,
            ],
        ]);
    }

    /** @test */
    public function count_only_until_ten_days_ago()
    {
        $redirect = Redirect::factory()->create();

        RedirectLog::factory()->count(10)->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
        ]);

        RedirectLog::factory()->count(7)->create([
            'redirect_id' => $redirect->id,
            'ip_address' => '127.0.0.1',
            'accessed_at' => now()->addDays(-11)->format('Y-m-d H:i:s'),
        ]);

        $response = $this->get(route('api.redirects.stats', $redirect->code));

        $response->assertJson([
            'total' => $redirect->logs->count(),
            'until_ten_days_ago' => [
                'total' => $redirect->logs
                    ->where('accessed_at', '>=', now()->addDays(-10)->format('Y-m-d H:i:s'))
                    ->count(),
            ],
        ]);
    }
}
