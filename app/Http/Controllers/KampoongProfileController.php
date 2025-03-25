<?php

namespace App\Http\Controllers;

use App\Helpers\MapHelper;
use Facades\App\Helpers\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KampoongProfileController extends Controller
{
    public function show(): View
    {
        return view('kampoong_profile.show');
    }

    public function edit(): View
    {
        $this->authorize('edit_kampoong_profile');

        return view('kampoong_profile.edit');
    }

    public function update(Request $request): RedirectResponse
    {
        $this->authorize('edit_kampoong_profile');

        $validatedPayload = $request->validate([
            'kampoong_name' => 'required|string|max:255',
            'kampoong_address' => 'required|string|max:255',
            'kampoong_city_name' => 'required|string|max:255',
            'kampoong_google_maps_link' => ['nullable', 'url', 'max:255'],
            'kampoong_whatsapp_number' => ['nullable', 'alpha_num', 'max:255'],
            'kampoong_instagram_username' => ['nullable', 'regex:/^(?!.*\.\.)(?!.*--)[a-zA-Z][a-zA-Z0-9._-]{4,31}$/', 'max:255'],
            'kampoong_youtube_username' => ['nullable', 'regex:/^(?!.*\.\.)(?!.*--)[a-zA-Z][a-zA-Z0-9._-]{4,31}$/', 'max:255'],
            'kampoong_facebook_username' => ['nullable', 'regex:/^(?!.*\.\.)(?!.*--)[a-zA-Z][a-zA-Z0-9._-]{4,31}$/', 'max:255'],
            'kampoong_telegram_username' => ['nullable', 'regex:/^(?!.*\.\.)(?!.*--)[a-zA-Z][a-zA-Z0-9._-]{4,31}$/', 'max:255'],
        ]);

        Setting::set('kampoong_name', $validatedPayload['kampoong_name']);
        Setting::set('kampoong_address', $validatedPayload['kampoong_address']);
        Setting::set('kampoong_city_name', $validatedPayload['kampoong_city_name']);
        Setting::set('kampoong_google_maps_link', $validatedPayload['kampoong_google_maps_link']);
        Setting::set('kampoong_whatsapp_number', $validatedPayload['kampoong_whatsapp_number']);
        Setting::set('kampoong_instagram_username', $validatedPayload['kampoong_instagram_username']);
        Setting::set('kampoong_youtube_username', $validatedPayload['kampoong_youtube_username']);
        Setting::set('kampoong_facebook_username', $validatedPayload['kampoong_facebook_username']);
        Setting::set('kampoong_telegram_username', $validatedPayload['kampoong_telegram_username']);

        flash(__('kampoong_profile.updated'), 'success');

        return redirect()->route('kampoong_profile.show');
    }

    public function coordinatesUpdate(Request $request): RedirectResponse
    {
        $this->authorize('edit_kampoong_profile');

        $validatedPayload = $request->validate([
            'google_maps_link' => 'required|string|max:255',
        ]);
        $coordinates = MapHelper::getCoordinatesFromGoogleMapsLink($validatedPayload['google_maps_link']);

        Setting::set('kampoong_latitude', $coordinates['latitude'] ?? null);
        Setting::set('kampoong_longitude', $coordinates['longitude'] ?? null);

        flash(__('kampoong_profile.coordinate_updated'), 'success');

        return redirect()->route('kampoong_profile.show');
    }
}
