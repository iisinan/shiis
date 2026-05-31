<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AccountantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the roles needed for tests
        Role::firstOrCreate(['name' => 'Accountant']);
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Member']);
    }

    public function test_accountant_can_view_dashboard_with_pending_payments()
    {
        $accountant = User::factory()->create();
        $accountant->assignRole('Accountant');

        $member = User::factory()->create(['name' => 'John Doe']);
        $payment = Payment::create([
            'user_id' => $member->id,
            'amount' => 5000,
            'reference' => 'TEST_REF_123',
            'receipt_path' => 'receipts/test.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($accountant)->get(route('accountant.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('₦5,000.00');
    }

    public function test_accountant_can_verify_payment()
    {
        $accountant = User::factory()->create();
        $accountant->assignRole('Accountant');

        $member = User::factory()->create([
            'name' => 'Jane Doe',
            'is_paid' => false,
            'is_active' => false,
        ]);
        
        $payment = Payment::create([
            'user_id' => $member->id,
            'amount' => 10000,
            'reference' => 'TEST_REF_456',
            'receipt_path' => 'receipts/test.jpg',
            'status' => 'pending',
        ]);

        // Verify the payment
        $response = $this->actingAs($accountant)
            ->post(route('accountant.verify', $payment));

        $response->assertRedirect();
        
        // Assert payment is success
        $this->assertEquals('success', $payment->fresh()->status);

        // Assert member is marked as paid and active
        $member = $member->fresh();
        $this->assertTrue($member->is_paid);
        $this->assertTrue($member->is_active);
    }
}
