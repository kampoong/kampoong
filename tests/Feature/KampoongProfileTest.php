<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class KampoongProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_user_can_visit_kampoong_profile_page()
    {
        $user = $this->loginAsUser();
        $this->visitRoute('kampoong_profile.show');
        $this->seeRouteIs('kampoong_profile.show');
    }

    /** @test */
    public function admin_user_can_update_kampoong_profile_data()
    {
        $user = $this->loginAsUser();

        $this->visitRoute('kampoong_profile.edit');

        $this->submitForm(__('kampoong_profile.update'), [
            'kampoong_name' => 'Kampoong Ar-Rahman',
            'kampoong_address' => 'Jln. Kalimantan, No. 20, Kota Banjarmasin',
            'kampoong_city_name' => 'Banjarmasin',
            'kampoong_google_maps_link' => 'https://maps.app.goo.gl/abcd',
            'kampoong_whatsapp_number' => '6281234567890',
            'kampoong_instagram_username' => 'abcda.123',
            'kampoong_youtube_username' => 'abcd-111',
            'kampoong_facebook_username' => 'abcd_123',
            'kampoong_telegram_username' => 'abcdaaa',
        ]);

        $this->see(__('kampoong_profile.updated'));
        $this->seeRouteIs('kampoong_profile.show');

        $this->seeInDatabase('settings', [
            'key' => 'kampoong_name',
            'value' => 'Kampoong Ar-Rahman',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_address',
            'value' => 'Jln. Kalimantan, No. 20, Kota Banjarmasin',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_city_name',
            'value' => 'Banjarmasin',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_google_maps_link',
            'value' => 'https://maps.app.goo.gl/abcd',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_whatsapp_number',
            'value' => '6281234567890',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_instagram_username',
            'value' => 'abcda.123',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_youtube_username',
            'value' => 'abcd-111',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_facebook_username',
            'value' => 'abcd_123',
        ]);
        $this->seeInDatabase('settings', [
            'key' => 'kampoong_telegram_username',
            'value' => 'abcdaaa',
        ]);
    }

    /** @test */
    public function user_can_get_kampoong_map_if_google_maps_link_exists()
    {
        DB::table('settings')->insert([
            'key' => 'kampoong_google_maps_link',
            'value' => 'https://maps.app.goo.gl/viUfQtHqjUXJHSLb8',
        ]);
        Http::fake([
            'https://maps.app.goo.gl/viUfQtHqjUXJHSLb8' => Http::response('', 302, [
                'Location' => 'https://www.google.com/maps/@-3.4331567,114.8409041,15z',
            ]),
        ]);

        $user = $this->loginAsUser();
        $this->visitRoute('kampoong_profile.show');
        $this->seeElement('button', ['type' => 'submit', 'id' => 'refresh_kampoong_map']);
        $this->press('refresh_kampoong_map');

        $this->seeInDatabase('settings', [
            'key' => 'kampoong_latitude',
            'value' => '-3.4331567',
        ]);

        $this->seeInDatabase('settings', [
            'key' => 'kampoong_longitude',
            'value' => '114.8409041',
        ]);
    }

    /** @test */
    public function user_failed_to_get_kampoong_map_if_google_maps_link_is_not_found()
    {
        DB::table('settings')->insert([
            'key' => 'kampoong_google_maps_link',
            'value' => 'https://maps.app.goo.gl/viUfQtHqjUXJHSLb8',
        ]);
        Http::fake([
            'https://maps.app.goo.gl/viUfQtHqjUXJHSLb8' => Http::response('', 404),
        ]);

        $user = $this->loginAsUser();
        $this->visitRoute('kampoong_profile.show');
        $this->seeElement('button', ['type' => 'submit', 'id' => 'refresh_kampoong_map']);
        $this->press('refresh_kampoong_map');

        $this->seeInDatabase('settings', [
            'key' => 'kampoong_latitude',
            'value' => null,
        ]);

        $this->seeInDatabase('settings', [
            'key' => 'kampoong_longitude',
            'value' => null,
        ]);
    }
}
