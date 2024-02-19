<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    /** @test */
    public function create_redirect_with_invalid_dns_url()
    {
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => 'https://' . Str::random(64) . '.com?test=jhhdhsdhj',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_redirect' => 'A URL possui um DNS inválido.']);
    }

    /** @test */
    public function create_redirect_with_valid_url()
    {
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => fake()->imageUrl(),
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/redirects')
            ->assertSessionHas('message', 'Redirect adicionado com sucesso!');
    }

    /** @test */
    public function create_redirect_with_invalid_url()
    {
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => 'https:/' . Str::random(5),
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_redirect' => 'URL de destino inválida.']);
    }

    /** @test */
    public function create_redirect_with_url_of_this_application()
    {
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => config('app.url') . '/test',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_redirect' => 'URL de destino não pode apontar para a própria aplicação.']);
    }

    /** @test */
    public function create_redirect_with_url_without_https()
    {
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => 'http://' . Str::random(10) . '.com',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_redirect' => 'URL de destino deve começar com "https".']);
    }

    /** @test */
    public function create_redirect_with_url_broken()
    {
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => 'https://classroom.google.com/u/1/hkaskksaks',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_redirect' => 'A URL aparentemente apresenta algum erro, tente acessá-la para ver o que pode ser.']);
    }

    /** @test */
    public function create_redirect_with_nullables_query_params_url()
    {
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => 'https://google.com?test=jhhdhsdhj&=1122',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['query_params.1.key' => 'As chaves dos parametros da URL são não pode ser vazio.']);
    }
}
