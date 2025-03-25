<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Facades\App\Helpers\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KampoongProfileController extends Controller
{
    public function updateLogo(Request $request)
    {
        $this->authorize('edit_kampoong_profile');

        $validatedPayload = $request->validate([
            'image' => 'required',
        ]);

        if (!base64_decode($validatedPayload['image'])) {
            return response()->json([
                'message' => __('kampoong_profile.image_not_found'),
            ]);
        }

        if ($kampoongLogoPath = Setting::get('kampoong_logo_path')) {
            Storage::delete($kampoongLogoPath);
        }

        $imageParts = explode(';base64,', $validatedPayload['image']);
        $imageBase64 = base64_decode($imageParts[1]);
        $imageName = uniqid().'.webp';

        Storage::put($imageName, $imageBase64);
        Setting::set('kampoong_logo_path', $imageName);

        return response()->json([
            'message' => __('kampoong_profile.logo_uploaded'),
            'image' => Storage::url($imageName),
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $this->authorize('edit_kampoong_profile');

        $validatedPayload = $request->validate([
            'image' => 'required',
        ]);

        if (!base64_decode($validatedPayload['image'])) {
            return response()->json([
                'message' => __('kampoong_profile.image_not_found'),
            ]);
        }

        if ($kampoongPhotoPath = Setting::get('kampoong_photo_path')) {
            Storage::delete($kampoongPhotoPath);
        }

        $imageParts = explode(';base64,', $validatedPayload['image']);
        $imageBase64 = base64_decode($imageParts[1]);
        $imageName = uniqid().'.webp';

        Storage::put($imageName, $imageBase64);
        Setting::set('kampoong_photo_path', $imageName);

        return response()->json([
            'message' => __('kampoong_profile.photo_uploaded'),
            'image' => Storage::url($imageName),
        ]);
    }

    public function show()
    {
        $kampoongName = Setting::get('kampoong_name', config('kampoong.name'));
        $kampoongAddress = Setting::get('kampoong_address');
        $kampoongGoogleMapsLink = Setting::get('kampoong_google_maps_link');
        $logoImageUrl = Setting::get('kampoong_logo_path');

        $response = [
            'kampoong_name' => $kampoongName,
            'kampoong_address' => $kampoongAddress,
            'google_maps_link' => $kampoongGoogleMapsLink,
            'logo_image_url' => Storage::url($logoImageUrl),
        ];

        return response()->json($response);
    }
}
