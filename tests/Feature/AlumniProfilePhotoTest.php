<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlumniProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function alumni_can_upload_then_and_now_photos_when_updating_profile()
    {
        Storage::fake('public');

        // create user and alumni
        $user = User::factory()->create(['user_role' => 'alumni']);
        $alumni = Alumni::create([
            'user_id' => $user->user_id,
            'alumni_name' => 'John Doe',
            'alumni_phone' => '0123456789',
            'alumni_email' => $user->user_email,
        ]);

        $this->actingAs($user);

        $childhood = UploadedFile::fake()->image('childhood.jpg');
        $current = UploadedFile::fake()->image('current.png');

        $response = $this->put(route('profile.update'), [
            'alumni_name' => 'John Doe',
            'alumni_phone' => '0123456789',
            'alumni_status' => 'studying',
            'institution' => 'Test University',
            'alumni_photo' => UploadedFile::fake()->image('profile.jpg'),
            'photo_childhood' => $childhood,
            'photo_current' => $current,
        ]);

        $response->assertRedirect(route('profile.show'));
        $response->assertSessionHas('success');

        $alumni->refresh();

        $this->assertNotNull($alumni->photo_childhood);
        $this->assertNotNull($alumni->photo_current);

        Storage::disk('public')->assertExists($alumni->photo_childhood);
        Storage::disk('public')->assertExists($alumni->photo_current);
    }
}
