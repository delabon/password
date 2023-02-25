<?php

namespace Tests\Unit;

use App\Models\Password;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_password_can_generated()
    {
        $password = new Password();
        $generated_pass = $password->generate();

        $this->assertEquals($generated_pass, Password::query()->first()->code);
    }

    /** @test */
    public function the_password_must_be_unique()
    {
        $password1 = new Password();
        $password1->generate();
        $generated_pass1 = Password::all()->get(0)->code;

        $password2 = new Password();
        $password2->generate();
        $generated_pass2 = Password::all()->get(1)->code;

        $this->assertNotEquals($generated_pass1, $generated_pass2);
    }
}
