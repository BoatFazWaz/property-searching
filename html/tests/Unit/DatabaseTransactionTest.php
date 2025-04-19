<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DatabaseTransactionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test demonstrating database transactions.
     */
    public function test_database_transactions_example(): void
    {
        // This test uses database transactions
        // All database changes made in this test will be rolled back after the test completes
        
        // Example assertion to show the test runs
        $this->assertTrue(true);
        
        // You can make database queries here and they will be rolled back
        // Example: $this->assertDatabaseCount('users', 0);
    }
} 