<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJson(
                fn(AssertableJson $json) => $json->hasAll(
                    [
                        'message',
                        'token',
                        'user',
                        'code'
                    ]
                )
            );
    }
}
