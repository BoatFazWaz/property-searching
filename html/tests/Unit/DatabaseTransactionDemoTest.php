<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;

class DatabaseTransactionDemoTest extends TestCase
{
    /**
     * A demonstration of the DatabaseTransactions trait.
     *
     * This test demonstrates how DatabaseTransactions works conceptually.
     * It uses a mock object instead of connecting to the database.
     */
    public function test_database_transactions_concept_with_mock(): void
    {
        // Create a mock of the database connection
        $mockDB = Mockery::mock('Database');
        
        // Mock the beginTransaction method
        $mockDB->shouldReceive('beginTransaction')
            ->once()
            ->andReturn(true);
            
        // Mock a database operation
        $mockDB->shouldReceive('execute')
            ->once()
            ->with('INSERT INTO properties VALUES (...)')
            ->andReturn(true);
            
        // Mock the rollback method that will be called after the test
        $mockDB->shouldReceive('rollBack')
            ->once()
            ->andReturn(true);
        
        // Simulate test execution
        $mockDB->beginTransaction();
        $mockDB->execute('INSERT INTO properties VALUES (...)');
        
        // This happens automatically with the DatabaseTransactions trait
        // after each test method completes
        $mockDB->rollBack();
        
        // Assert that all expected method calls were made
        $this->assertTrue(true);
    }
    
    /**
     * Explanation of how DatabaseTransactions works in Laravel
     */
    public function test_explain_database_transactions(): void
    {
        // When using the DatabaseTransactions trait, Laravel automatically:
        // 1. Starts a database transaction before each test
        // $this->getConnection()->beginTransaction();
        
        // 2. Your test runs and makes database changes
        // Example: Property::create(['title' => 'Test Property']);
        
        // 3. After the test completes (regardless of pass/fail), Laravel rolls back the transaction
        // $this->getConnection()->rollBack();
        
        // This ensures that no test data persists between tests
        // Each test starts with a clean database state
        
        $this->assertTrue(true);
    }
    
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
} 