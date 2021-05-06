<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{

    public function test_only_members_can_add_avatars()
    {
        $this->postJson('api/users/1/avatar')
            ->assertUnauthorized();
    }

    public function test_a_valid_avatar_must_be_provided()
    {
        $this->signIn();

        $this->postJson('api/users/' . auth()->id() . '/avatar', [
            'avatar' => 'not-an-image'
        ])->assertStatus(422);
    }

    public function test_a_user_may_add_an_avatar_to_their_profile()
    {
        Storage::fake('public');

        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->postJson('api/users/' . auth()->id() . '/avatar', [
            'avatar' => $file
        ]);

        $this->assertEquals(
            'avatars/' . $file->hashName(),
            auth()->user()->avatar_path
        );

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
