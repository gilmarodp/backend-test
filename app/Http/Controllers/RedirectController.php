<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedirectRequest;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $redirects = Redirect::query()
            ->with('logs')
            ->orderByDesc('id')
            ->paginate(15);

        return view('redirects.index', compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('redirects.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RedirectRequest $request)
    {
        $parseUrl = parse_url($request->get('url_redirect'));

        if (!checkdnsrr($parseUrl['host'], 'A') && !checkdnsrr($parseUrl['host'], 'AAAA')) {
            return redirect()
                ->route('redirects.create')
                ->withErrors([
                    'url_redirect' => 'A URL possui um DNS inválido.',
                ]);
        }

        $urlExists = Http::get($request->get('url_redirect'))->ok();

        if (!$urlExists) {
            return redirect()
                ->route('redirects.create')
                ->withErrors([
                    'url_redirect' => 'A URL aparentemente apresenta algum erro, tente acessá-la para ver o que pode ser.',
                ]);
        }

        $redirect = new Redirect();
        $redirect->url_redirect = $request->get('url_redirect');
        $redirect->status = 1;
        $redirect->save();

        return redirect()
            ->route('redirects.index')
            ->withMessage('Redirect adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Redirect  $redirect
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Redirect $redirect)
    {
        return view('redirects.edit', compact('redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Redirect  $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RedirectRequest $request, Redirect $redirect)
    {
        $redirect->url_redirect = $request->get('url_redirect');
        $redirect->status = $request->get('status');
        $redirect->save();

        return redirect()
            ->route('redirects.edit', $redirect->code)
            ->withMessage('Redirect editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirect $redirect)
    {
        $redirect->status = 0;
        $redirect->save();

        $redirect->delete();

        return redirect()
            ->route('redirects.index')
            ->withMessage('Redirect excluído com sucesso!');
    }

    public function redirect(Request $request, Redirect $redirect)
    {
        $parseUrl = parse_url($redirect->url_redirect);
        $queryParamsRequest = collect($request->all())->filter(fn($value) => !is_null($value) && $value !== "");
        $urlRedirect = $parseUrl['scheme'] . '://' . $parseUrl['host'] . $parseUrl['path'];
        parse_str($parseUrl['query'], $queryParamsRedirect);

        $queryParamsRedirect = collect($queryParamsRedirect)->filter(fn($value) => !is_null($value) && $value !== "");

        $queryParams = $queryParamsRedirect->merge($queryParamsRequest);
        $queryParams = $queryParams->filter(function ($value) {
            return !is_null($value) && $value !== "";
        });

        $redirect->logs()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'header_refer' => $request->headers->get('referer'),
            'query_params' => $queryParams->toJson(),
            'accessed_at' => date('Y-m-d H:i:s'),
        ]);

        $queryParams = $queryParams->count() ? '?' . http_build_query($queryParams->toArray()) : '';

        return redirect()->to($urlRedirect . $queryParams);
    }
}
