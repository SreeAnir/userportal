<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_make_payment()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Mock payment gateway response
        // Simulate a POST request to your payment route
        $response = $this->post('/payment', [
            'amount' => 1000,
            'payment_method' => 'test_card_token',
        ]);

        $response->assertStatus(200); // or redirect, depending on your logic
        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'amount' => 1000,
            'status' => 'paid',
        ]);
    }

    public function test_payment_fails_with_invalid_token()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/payment', [
            'amount' => 1000,
            'payment_method' => 'invalid_token',
        ]);

        $response->assertStatus(422); // or appropriate status for failure
        $this->assertDatabaseMissing('payments', [
            'user_id' => $user->id,
            'amount' => 1000,
        ]);
    }
}
