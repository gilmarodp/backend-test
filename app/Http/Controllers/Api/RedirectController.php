<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RedirectLogResource;
use App\Http\Resources\RedirectResource;
use App\Models\Redirect;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $redirects = Redirect::all();

        return response()->json(RedirectResource::collection($redirects));
    }

    public function logs(Redirect $redirect)
    {
        return response()->json(RedirectLogResource::collection($redirect->logs));
    }
}
