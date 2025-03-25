<?php

namespace Tests\Feature\Api;

use Facades\App\Helpers\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KampoongProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_kampoong_details()
    {
        Setting::set('kampoong_name', 'Kampoong Ar-Rahman');
        Setting::set('kampoong_address', 'Jln. Kalimantan, No. 20, Kota Banjarmasin');
        Setting::set('kampoong_google_maps_link', 'https://maps.app.goo.gl/abcd');
        Setting::set('kampoong_logo_path', uniqid().'.webp');

        $kampoongName = Setting::get('kampoong_name', config('kampoong.name'));
        $kampoongAddress = Setting::get('kampoong_address');
        $kampoongGoogleMapsLink = Setting::get('kampoong_google_maps_link');
        $logoImageUrl = Setting::get('kampoong_logo_path');

        $this->getJson(route('api.kampoong_profile.show'));

        $this->seeJson([
            'kampoong_name' => $kampoongName,
            'kampoong_address' => $kampoongAddress,
            'google_maps_link' => $kampoongGoogleMapsLink,
            'logo_image_url' => Storage::url($logoImageUrl),
        ]);
    }

    /** @test */
    public function update_kampoong_logo_with_csrf_token()
    {
        $this->loginAsUser();
        $this->dontSeeInDatabase('settings', ['key' => 'kampoong_logo_path']);

        $this->get(route('home'));
        $this->seeStatusCode(200);

        $csrfToken = csrf_token();
        Storage::fake(config('filesystem.default'));
        $image = UploadedFile::fake()->image('logo.jpg');
        $base64Image = 'data:image/png;base64,'.base64_encode(file_get_contents($image->getPathname()));

        $this->post(route('api.kampoong_profile.upload_logo'), [
            '_token' => $csrfToken,
            'image' => $base64Image,
        ]);

        $this->seeStatusCode(200);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_logo_path',
        ]);

        $settingRecord = DB::table('settings')->where('key', 'kampoong_logo_path')->first();
        Storage::assertExists($settingRecord->value);
        $this->seeJson([
            'message' => __('kampoong_profile.logo_uploaded'),
            'image' => Storage::url($settingRecord->value),
        ]);
    }

    /** @test */
    public function update_kampoong_photo_with_csrf_token()
    {
        $this->loginAsUser();
        $this->dontSeeInDatabase('settings', ['key' => 'kampoong_photo_path']);

        $this->get(route('home'));
        $this->seeStatusCode(200);

        $csrfToken = csrf_token();
        Storage::fake(config('filesystem.default'));
        $image = UploadedFile::fake()->image('photo.jpg');
        $base64Image = 'data:image/png;base64,'.base64_encode(file_get_contents($image->getPathname()));

        $this->post(route('api.kampoong_profile.upload_photo'), [
            '_token' => $csrfToken,
            'image' => $base64Image,
        ]);

        $this->seeStatusCode(200);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_photo_path',
        ]);

        $settingRecord = DB::table('settings')->where('key', 'kampoong_photo_path')->first();
        Storage::assertExists($settingRecord->value);
        $this->seeJson([
            'message' => __('kampoong_profile.photo_uploaded'),
            'image' => Storage::url($settingRecord->value),
        ]);
    }
}
