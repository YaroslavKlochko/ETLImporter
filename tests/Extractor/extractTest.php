<?php
use PHPUnit\Framework\TestCase;

require_once 'src/Extractor/extract.php';

class extractTest extends TestCase {
    public function testExtractAccounts() {
        $accountsJson = '[
            {"id": "1020100", "number": "1020-100", "description": "Bank account, operating", "created": "2019-01-01T00:00:00", "isActive": true},
            {"id": "1030100", "number": "1030-100", "description": "Bank account, payroll", "created": "2019-01-01T00:00:00", "isActive": true}
        ]';

        $expectedExtractedAccounts = json_decode($accountsJson, true);
        $extractedAccounts = extractAccounts();
        $this->assertEquals($expectedExtractedAccounts, $extractedAccounts);
    }

    public function testExtractVendors() {
        $vendorsJson = '[
            {"id": "1234", "name": "Goldman Sachs", "shortName": "GOLDSACH", "groupCode": "INV", "lastModified": "1984-04-24T00:00:00", "isActive": true, "currency": "USD", "terms": "DUETBL", "contact": "Lloyd Blankfein", "address1": "200 West Street", "city": "New York", "state": "NY", "postalCode": "10282", "country": "USA", "phone": "2129020300"},
            {"id": "4321", "name": "Excide Industrial Batteries", "shortName": "EXIDE", "groupCode": "INV", "lastModified": "2010-08-18T00:00:00", "isActive": false, "currency": "CAD", "terms": "P90", "contact": "Mr. J. Everley", "address1": "486 Central Blvd", "city": "Houston", "state": "TX", "postalCode": "67182", "country": "USA", "phone": "7135554799", "fax": "7135553201"},
            {"id": "12345", "name": "Vendor New Line Replacer Test", "shortName": "VendorNewLineReplacer", "groupCode": "CRE", "lastModified": "2019-04-30T00:00:00", "isActive": true, "currency": "CAD", "terms": "CREDIT", "contact": "John Doe", "address1": "address line 1\n\rSuite 300", "address2": "address line 2\n\r", "address3": "address line 3\n\r", "address4": "address line 4", "city": "San Diego", "state": "CA", "postalCode": "92101", "country": "USA", "phone": "6192321234"}
        ]';

        $expectedExtractedVendors = json_decode($vendorsJson, true);
        $extractedVendors = extractVendors();
        $this->assertEquals($expectedExtractedVendors, $extractedVendors);
    }

    public function testExtractBankAccounts() {
        $bankAccountsJson = '[
        {"id": "CCB", "name": "City Commercial Bank", "account": "1020-100", "currency": "USD", "lastModified": "2017-01-24T00:00:00", "isActive": true},
        {"id": "PRBANK", "name": "Second National Bank", "account": "1030-100", "currency": "CAD", "lastModified": "2013-11-12T00:00:00", "isActive": false},
        {"id": "VISASTB", "name": "Visa Seattle Tacoma Bank", "account": "1030-100", "currency": "USD", "lastModified": "2010-08-18T00:00:00", "isActive": true}
    ]';

        $expectedExtractedBankAccounts = json_decode($bankAccountsJson, true);
        $extractedBankAccounts = extractBankAccounts();
        $this->assertEquals($expectedExtractedBankAccounts, $extractedBankAccounts);
    }
}
