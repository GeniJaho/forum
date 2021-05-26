<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_users_can_see_the_homepage()
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('home');

        $this->signIn();

        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('home');
    }
}
