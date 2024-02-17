<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedirectRequest;
use App\Models\Redirect;
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
        $urlExists = Http::get($request->url_redirect)->ok();

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
}
