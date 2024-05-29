<?php

require_once 'src/Extractor/extract.php';
require_once 'src/logger.php';

$accounts = extractAccounts();
$vendors = extractVendors();
$bankAccounts = extractBankAccounts();

logMessage('JSON files extracted successfully.', LOG_LEVEL_INFO);

$transformedAccounts = transformAccounts($accounts);
$transformedVendors = transformVendors($vendors);
$transformedBankAccounts = transformBankAccounts($bankAccounts);

function transformAccounts($accounts) {
    $transformedAccounts = array_map(function($account) {
        return [
            'id' => $account['id'],
            'number' => $account['number'],
            'description' => $account['description'],
            'created' => $account['created'],
            'is_active' => $account['isActive'] ? 'true' : 'false',
        ];
    }, $accounts);
    logMessage("Accounts data transformed.", LOG_LEVEL_INFO);
    return $transformedAccounts;
}

function transformVendors($vendors) {
    $transformedVendors = array_map(function($vendor) {
        return [
            'id' => $vendor['id'],
            'name' => $vendor['name'],
            'short_name' => $vendor['shortName'],
            'group_code' => $vendor['groupCode'],
            'last_modified' => $vendor['lastModified'],
            'is_active' => $vendor['isActive'] ? 'true' : 'false',
            'currency' => $vendor['currency'],
            'terms' => $vendor['terms'],
            'contact' => $vendor['contact'],
            'address1' => $vendor['address1'],
            'city' => $vendor['city'],
            'state' => $vendor['state'],
            'postal_code' => $vendor['postalCode'],
            'country' => $vendor['country'],
            'phone' => $vendor['phone'],
        ];
    }, $vendors);
    logMessage("Vendors data transformed.", LOG_LEVEL_INFO);
    return $transformedVendors;
}

function transformBankAccounts($bankAccounts) {
    $transformedBankAccounts = array_map(function($bankAccount) {
        return [
            'id' => $bankAccount['id'],
            'name' => $bankAccount['name'],
            'account' => $bankAccount['account'],
            'currency' => $bankAccount['currency'],
            'last_modified' => $bankAccount['lastModified'],
            'is_active' => $bankAccount['isActive'] ? 'true' : 'false',
        ];
    }, $bankAccounts);
    logMessage("Bank accounts data transformed.", LOG_LEVEL_INFO);
    return $transformedBankAccounts;
}
