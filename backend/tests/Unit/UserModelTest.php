<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;

class UserModelTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Speed up bcrypt hashing for tests
        Hash::setRounds(4);
    }

    /** @test */
    public function it_allows_mass_assignment_for_fillable_fields()
    {
        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue(Hash::check('secret', $user->password));
    }

    /** @test */
    public function it_hides_password_and_remember_token_when_serialized()
    {
        $user = new User([
            'name' => 'Hidden Fields',
            'email' => 'hidden@example.com',
            'password' => 'hidden',
            'remember_token' => 'token123'
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('email', $array);
    }


    /** @test */
    public function it_casts_email_verified_at_as_datetime()
    {
        $now = now();
        $user = new User();
        $user->forceFill(['email_verified_at' => $now]);

        $value = $user->getAttribute('email_verified_at');

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $value);
    }

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $expected = ['name', 'email', 'password'];
        $this->assertEquals($expected, (new User)->getFillable());
    }

    /** @test */
    public function it_has_expected_hidden_attributes()
    {
        $expected = ['password', 'remember_token'];
        $this->assertEquals($expected, (new User)->getHidden());
    }
}
