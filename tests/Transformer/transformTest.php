<?php

namespace Transformer;

use PHPUnit\Framework\TestCase;

require_once 'src/Transformer/transform.php';

class transformTest extends TestCase
{
    public function testTransformForAccounts() {
        $accountsJson = '[
            {"id": "1", "number": "1001", "description": "Account 1", "created": "2024-05-28 10:00:00", "isActive": true},
            {"id": "2", "number": "1002", "description": "Account 2", "created": "2024-05-28 11:00:00", "isActive": false}
        ]';
        $accounts = json_decode($accountsJson, true);

        $expectedTransformedAccounts = [
            ['id' => '1', 'number' => '1001', 'description' => 'Account 1', 'created' => '2024-05-28 10:00:00', 'is_active' => 'true'],
            ['id' => '2', 'number' => '1002', 'description' => 'Account 2', 'created' => '2024-05-28 11:00:00', 'is_active' => 'false'],
        ];

        $transformedAccounts = transformAccounts($accounts);
        $this->assertEquals($expectedTransformedAccounts, $transformedAccounts);
    }

    public function testTransformForVendors()
    {
        $vendorsJson = '[
            {"id": "101", "name": "Vendor 1", "shortName": "V1", "groupCode": "GRP1", "lastModified": "2024-05-28 10:00:00", "isActive": true, "currency": "USD", "terms": "Net 30", "contact": "John Doe", "address1": "123 Main St", "city": "Anytown", "state": "CA", "postalCode": "12345", "country": "USA", "phone": "123-456-7890"},
            {"id": "102", "name": "Vendor 2", "shortName": "V2", "groupCode": "GRP2", "lastModified": "2024-05-28 11:00:00", "isActive": false, "currency": "EUR", "terms": "Net 15", "contact": "Jane Doe", "address1": "456 Elm St", "city": "Othertown", "state": "NY", "postalCode": "54321", "country": "USA", "phone": "987-654-3210"}
        ]';
        $vendors = json_decode($vendorsJson, true);

        $expectedTransformedVendors = [
            ['id' => '101', 'name' => 'Vendor 1', 'short_name' => 'V1', 'group_code' => 'GRP1', 'last_modified' => '2024-05-28 10:00:00', 'is_active' => 'true', 'currency' => 'USD', 'terms' => 'Net 30', 'contact' => 'John Doe', 'address1' => '123 Main St', 'city' => 'Anytown', 'state' => 'CA', 'postal_code' => '12345', 'country' => 'USA', 'phone' => '123-456-7890'],
            ['id' => '102', 'name' => 'Vendor 2', 'short_name' => 'V2', 'group_code' => 'GRP2', 'last_modified' => '2024-05-28 11:00:00', 'is_active' => 'false', 'currency' => 'EUR', 'terms' => 'Net 15', 'contact' => 'Jane Doe', 'address1' => '456 Elm St', 'city' => 'Othertown', 'state' => 'NY', 'postal_code' => '54321', 'country' => 'USA', 'phone' => '987-654-3210'],
        ];

        $transformedVendors = transformVendors($vendors);
        $this->assertEquals($expectedTransformedVendors, $transformedVendors);
    }

    public function testTransformForBankAccounts()
    {
        $bankAccountsJson = '[
            {"id": "201", "name": "Bank 1", "account": "123456789", "currency": "USD", "lastModified": "2024-05-28 10:00:00", "isActive": true},
            {"id": "202", "name": "Bank 2", "account": "987654321", "currency": "EUR", "lastModified": "2024-05-28 11:00:00", "isActive": false}
        ]';
        $bankAccounts = json_decode($bankAccountsJson, true);

        $expectedTransformedBankAccounts = [
            ['id' => '201', 'name' => 'Bank 1', 'account' => '123456789', 'currency' => 'USD', 'last_modified' => '2024-05-28 10:00:00', 'is_active' => 'true'],
            ['id' => '202', 'name' => 'Bank 2', 'account' => '987654321', 'currency' => 'EUR', 'last_modified' => '2024-05-28 11:00:00', 'is_active' => 'false'],
        ];

        $transformedBankAccounts = transformBankAccounts($bankAccounts);
        $this->assertEquals($expectedTransformedBankAccounts, $transformedBankAccounts);
    }
}
