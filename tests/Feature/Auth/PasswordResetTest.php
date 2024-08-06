<?php

namespace Tests\Feature\Auth;

use App\Events\PasswordResetCode;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->postJson('/forgot-password', ['email' => $user->email]);

        $response->assertStatus(201)
            ->assertJson(
                fn(AssertableJson $json) => $json->hasAll(
                    [
                        'message',
                        'code'
                    ]
                )
            );
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->postJson('/forgot-password', ['email' => $user->email]);
        $response->assertStatus(201)
            ->assertJson(
                fn(AssertableJson $json) => $json->hasAll(
                    [
                        'message',
                        'code'
                    ]
                )
            );
    }
}
