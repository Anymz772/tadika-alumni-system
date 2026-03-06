<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Tadika;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TadikaOwnerAlumniTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A tadika owner should be able to view their alumni list.
     */
    public function test_owner_can_view_alumni_list()
    {
        $owner = User::factory()->create(['user_role' => 'tadika_owner']);
        $tadika = Tadika::create([
            'user_id' => $owner->user_id,
            'tadika_name' => 'Sample Tadika',
            'tadika_reg_no' => 'REG123',
            'tadika_district' => 'Test',
            'tadika_state' => 'Test',
            'tadika_postcode' => '00000'
        ]);

        // create some alumni belonging to this tadika
        for ($i = 0; $i < 3; $i++) {
            Alumni::create([
                'tadika_id' => $tadika->tadika_id,
                'alumni_name' => "Person $i",
                'alumni_ic' => 'A123456789012',
                'alumni_phone' => '0123456789',
                'alumni_status' => 'studying',
                'alumni_address' => 'Address',
                'alumni_email' => "person{$i}@example.com",
            ]);
        }

        $response = $this->actingAs($owner)->get(route('tadika.alumni'));

        $response->assertStatus(200);
        $response->assertSee('Alumni List');
    }

    public function test_owner_can_edit_alumni_of_their_tadika()
    {
        $owner = User::factory()->create(['user_role' => 'tadika_owner']);
        $tadika = Tadika::create([
            'user_id' => $owner->user_id,
            'tadika_name' => 'Sample Tadika',
            'tadika_reg_no' => 'REG123',
            'tadika_district' => 'Test',
            'tadika_state' => 'Test',
            'tadika_postcode' => '00000'
        ]);
        $alumni = Alumni::create([
            'tadika_id' => $tadika->tadika_id,
            'alumni_name' => 'Edit Me',
            'alumni_ic' => 'A123456789012',
            'alumni_phone' => '0123456789',
            'alumni_status' => 'studying',
            'alumni_address' => 'Address',
            'alumni_email' => 'edit@example.com',
        ]);

        $response = $this->actingAs($owner)->get(route('tadika.alumni.edit', $alumni));
        $response->assertStatus(200);
        $response->assertSee($alumni->alumni_name);
    }

    public function test_owner_cannot_edit_alumni_of_other_tadika()
    {
        $owner = User::factory()->create(['user_role' => 'tadika_owner']);
        $otherTadika = Tadika::create([
            'user_id' => null,
            'tadika_name' => 'Other',
            'tadika_reg_no' => 'X123',
            'tadika_district' => 'X',
            'tadika_state' => 'X',
            'tadika_postcode' => '11111'
        ]);
        $alumni = Alumni::create([
            'tadika_id' => $otherTadika->tadika_id,
            'alumni_name' => 'Other Person',
            'alumni_ic' => 'B123456789012',
            'alumni_phone' => '0987654321',
            'alumni_status' => 'working',
            'alumni_address' => 'Other address',
            'alumni_email' => 'other@example.com',
        ]);

        $response = $this->actingAs($owner)->get(route('tadika.alumni.edit', $alumni));
        $response->assertStatus(403);
    }

    public function test_owner_can_view_message_all_form()
    {
        $owner = User::factory()->create(['user_role' => 'tadika_owner']);
        Tadika::factory()->create(['user_id' => $owner->user_id]);

        $response = $this->actingAs($owner)->get(route('tadika.alumni.message_all.form'));
        $response->assertStatus(200);
        $response->assertSee('Send message');
    }

    public function test_owner_can_click_view_alumni_profile_and_see_then_now_photos()
    {
        $owner = User::factory()->create(['user_role' => 'tadika']);
        $tadika = Tadika::create([
            'user_id' => $owner->user_id,
            'tadika_name' => 'Sample Tadika',
            'tadika_reg_no' => 'REG123',
            'tadika_district' => 'Test',
            'tadika_state' => 'Test',
            'tadika_postcode' => '00000',
        ]);

        $alumni = Alumni::create([
            'tadika_id' => $tadika->tadika_id,
            'alumni_name' => 'Photo User',
            'alumni_ic' => 'A123456789013',
            'alumni_phone' => '0123456789',
            'alumni_status' => 'studying',
            'institution' => 'Test University',
            'alumni_address' => 'Address',
            'alumni_email' => 'photo@example.com',
            'photo_childhood' => 'alumni_then_now/childhood.jpg',
            'photo_current' => 'alumni_then_now/current.jpg',
        ]);

        $listResponse = $this->actingAs($owner)->get(route('tadika.alumni'));
        $listResponse->assertStatus(200);
        $listResponse->assertSee(route('tadika.alumni.show', $alumni));

        $showResponse = $this->actingAs($owner)->get(route('tadika.alumni.show', $alumni));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Childhood');
        $showResponse->assertSee('Current');
        $showResponse->assertSee('alumni_then_now/childhood.jpg');
        $showResponse->assertSee('alumni_then_now/current.jpg');
    }
}
