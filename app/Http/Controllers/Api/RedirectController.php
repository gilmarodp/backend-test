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
        return response()->json(RedirectLogResource::collection($redirect->logs->sortByDesc('accessed_at')));
    }

    public function stats(Redirect $redirect)
    {
        $logs = $redirect->logs;
        $topReferrers = collect();

        foreach ($logs->groupBy('header_refer') as $key => $refer) {
            $topReferrers = $topReferrers->push(collect([
                'header_refer' => $key,
                'count' => $refer->count(),
            ]));
        }

        $response = [
            'total' => $logs->count(),
            'unique' => $logs->unique('ip_address')->count(),
            'top_referrers' => $topReferrers->sortByDesc('count')->values(),
            'until_ten_days_ago' => [
                'date' => now()->addDays(-10)->format('Y-m-d'),
                'total' => $logs->where('accessed_at', '>=', now()->addDays(-10)->format('Y-m-d H:i:s'))->count(),
                'unique' => $logs->where('accessed_at', '>=', now()->addDays(-10)->format('Y-m-d H:i:s'))->unique('ip_address')->count(),
            ],
        ];

        return response()->json($response);
    }
}
