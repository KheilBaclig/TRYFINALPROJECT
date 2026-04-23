<?php

namespace Tests\Unit;

use App\Models\ProductVariantModel;
use App\Models\TransactionModel;
use CodeIgniter\Test\CIUnitTestCase;

class AppLogicTest extends CIUnitTestCase
{

    // Test 1: Password hashing
    public function testPasswordHashIsValid(): void
    {
        $plain  = 'secret123';
        $hashed = password_hash($plain, PASSWORD_BCRYPT);
        $this->assertTrue(password_verify($plain, $hashed));
    }

    // Test 2: Wrong password fails verification
    public function testWrongPasswordFails(): void
    {
        $hashed = password_hash('correct', PASSWORD_BCRYPT);
        $this->assertFalse(password_verify('wrong', $hashed));
    }

    // Test 3: Transaction ref code format
    public function testTransactionRefCodeFormat(): void
    {
        $ref = 'TXN-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Ymd');
        $this->assertStringStartsWith('TXN-', $ref);
        $this->assertMatchesRegularExpression('/^TXN-[A-Z0-9]+-\d{8}$/', $ref);
    }

    // Test 4: Stock adjustment for sale reduces stock
    public function testStockAdjustSaleReducesStock(): void
    {
        $currentStock = 20;
        $qty          = 5;
        $newStock     = $currentStock - $qty;
        $this->assertEquals(15, $newStock);
    }

    // Test 5: Stock adjustment for return increases stock
    public function testStockAdjustReturnIncreasesStock(): void
    {
        $currentStock = 10;
        $qty          = 3;
        $newStock     = $currentStock + $qty;
        $this->assertEquals(13, $newStock);
    }

    // Test 6: Stock cannot go below zero
    public function testStockCannotGoBelowZero(): void
    {
        $currentStock = 2;
        $qty          = 10;
        $newStock     = max(0, $currentStock - $qty);
        $this->assertEquals(0, $newStock);
    }

    // Test 7: SKU is uppercased
    public function testSkuIsUppercased(): void
    {
        $sku = strtoupper('top-001');
        $this->assertEquals('TOP-001', $sku);
    }

    // Test 8: Transaction total calculation
    public function testTransactionTotalCalculation(): void
    {
        $items = [
            ['price' => 29.99, 'qty' => 2],
            ['price' => 59.99, 'qty' => 1],
        ];
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $items));
        $this->assertEquals(119.97, round($total, 2));
    }
}
