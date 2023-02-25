<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_password_can_be_generated_by_a_guest(): void
    {
        $response = $this->post('/password');

        $response->assertOk();
        $this->assertEquals(16, strlen($response->getContent()));
    }

    /** @test */
    public function password_generated_must_be_unqiue(): void
    {
        $response = $this->post('/password');
        $response2 = $this->post('/password');

        $response->assertOk();
        $response2->assertOk();
        $this->assertNotEquals($response->getContent(), $response2->getContent());
    }
}
