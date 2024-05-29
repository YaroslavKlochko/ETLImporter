<?php
require_once 'src/db_configuration.php';
require_once 'src/logger.php';

$accounts = extractAccounts();
$vendors = extractVendors();
$bankAccounts = extractBankAccounts();

logMessage('JSON files extracted successfully.', LOG_LEVEL_INFO);

function extractAccounts() {
    $accountsData = json_decode(file_get_contents('data/accounts.json'), true);
    logMessage("Accounts data extracted.", LOG_LEVEL_INFO);
    return $accountsData;
}

function extractVendors() {
    $vendorsData = json_decode(file_get_contents('data/vendors.json'), true);
    logMessage("Vendors data extracted.", LOG_LEVEL_INFO);
    return $vendorsData;
}

function extractBankAccounts() {
    $bankAccountsData = json_decode(file_get_contents('data/bank_accounts.json'), true);
    logMessage("Bank accounts data extracted.", LOG_LEVEL_INFO);
    return $bankAccountsData;
}
