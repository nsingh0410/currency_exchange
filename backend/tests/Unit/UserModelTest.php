<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_mass_assignment_for_fillable_fields()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('secret123')
        ]);

        $this->assertEquals('Jane Doe', $user->name);
        $this->assertEquals('jane@example.com', $user->email);
    }

    public function test_hides_password_and_remember_token_when_serialized()
    {
        $user = new User([
            'name' => 'Hidden Test',
            'email' => 'hidden@example.com',
            'password' => 'secret',
            'remember_token' => Str::random(10),
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_casts_email_verified_at_as_datetime()
    {
        $user = new User();
        $user->email_verified_at = '2024-01-01 10:00:00';

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
    }

    public function test_user_model_logs_lifecycle_events()
    {
        Log::spy();

        $user = User::factory()->create([
            'email' => 'log@example.com'
        ]);
        $user->update(['name' => 'Updated Name']);
        $user->delete();

        Log::shouldHaveReceived('info')->with('User created', ['id' => $user->id, 'email' => 'log@example.com']);
        Log::shouldHaveReceived('info')->with('User updated', ['id' => $user->id, 'email' => 'log@example.com']);
        Log::shouldHaveReceived('warning')->with('User deleted', ['id' => $user->id, 'email' => 'log@example.com']);
    }
}
