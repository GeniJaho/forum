<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_only_signed_in_users_can_see_the_homepage()
    {
        $this->get(route('home'))
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('home');
    }
}
