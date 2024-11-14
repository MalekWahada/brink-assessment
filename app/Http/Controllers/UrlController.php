<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class UrlController extends Controller
{
    public function create(): View|Factory|Application
    {
        return view('shorten');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'originalUrl' => 'required|url',
            'expireAt' => 'required|string',
        ]);

        $expireAt = self::calculateExpiration(
            $request->str('expireAt'),
            $request->date('customExpiration')
        );

        $url = Url::createUrl(
            $request->input('originalUrl'),
            $expireAt
        );

        return redirect()->route('url.show', ['shortCode' => $url->short_code]);
    }

    public function redirect($shortCode): Application|Response|Redirector|RedirectResponse|ResponseFactory
    {
        $url = Url::where('short_code', $shortCode)->firstOrFail();

        if ($url->expire_at && now()->greaterThan($url->expire_at)) {
            return response("This link has expired.", 410);
        }

        // Increment visit count and redirect
        $url->increment('visit_count');
        $url->update(['last_visited_at' => now()]);

        return redirect($url->original_url);
    }

    public function show($shortCode): View|Factory|Application
    {
        // Retrieve the shortened URL data
        $url = Url::where('short_code', $shortCode)->firstOrFail();

        if (!$url instanceof Url) {
            return redirect(404);
        }

        if (Carbon::parse($url->expire_at)->isPast()) {
            return view('expired');
        }

        return view('show', compact('url'));
    }

    public function index(): View|Factory|Application
    {
        $urls = Url::all();
        return view('admin.index', compact('urls'));
    }

    protected function calculateExpiration(string $expirationOption, ?Carbon $customExpiration = null): ?Carbon
    {
        return match ($expirationOption) {
            '24_hours' => Carbon::now()->addHours(24),
            '7_days' => Carbon::now()->addDays(7),
            'custom' => $customExpiration ? Carbon::parse($customExpiration) : null,
            default => null,
        };
    }
}
