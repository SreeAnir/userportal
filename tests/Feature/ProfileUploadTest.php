<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileUploadTest extends TestCase
{
    public function test_profile_pic_can_be_uploaded()
        {
            $user = \App\Models\User::factory()->create();
            $this->actingAs($user);

            $file = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg');

            $response = $this->put('/profile', [
                'name' => 'Updated User',
                'profile_pic' => $file,
            ]);

            $response->assertRedirect();
            $this->assertNotNull($user->fresh()->profile_pic);
            Storage::disk('public')->assertExists($user->fresh()->profile_pic);
        }
}
