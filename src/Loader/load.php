<?php

global $config;
require_once 'src/db_configuration.php';
require_once 'src/logger.php';
require_once 'src/Extractor/extract.php';
require_once 'src/Transformer/transform.php';

$pdo = getDbConnection($config);


/**  The loadData function aimed to insert or update data if it exists already. */
function loadData($pdo, $table, $data) {
    try {
        if (!is_array($data)) {
            throw new Exception('Data is not an array or is null');
        }

        foreach ($data as $row) {
            // Ensure all fields are properly set to avoid SQL errors.
            foreach ($row as $key => $value) {
                if ($value === "") {
                    $row[$key] = null; // Set empty strings to null.
                }
                if (is_bool($value)) {
                    $row[$key] = $value ? 'true' : 'false';
                }
            }

            $id = $row['id'];
            if ($id === null) {
                logMessage("Skipping record with null id in $table.", LOG_LEVEL_WARNING);
                continue;
            }

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $exists = $stmt->fetchColumn();

            if ($exists) {
                // Update the existing record
                $updateAssignments = implode(", ", array_map(function($col, $val) { return "$col = :$col"; }, array_keys($row), array_values($row)));
                $updateQuery = "UPDATE $table SET $updateAssignments WHERE id = :id";
                $stmt = $pdo->prepare($updateQuery);
                $row['id'] = $id; // Ensure id is in the parameter array.
                $stmt->execute($row);
                logMessage("Record with id $id updated in $table.", LOG_LEVEL_INFO);
            } else {
                // Insert a new record
                $columns = implode(", ", array_keys($row));
                $placeholders = implode(", ", array_map(function($col) { return ":$col"; }, array_keys($row)));
                $insertQuery = "INSERT INTO $table ($columns) VALUES ($placeholders)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->execute($row);
                logMessage("Record with id $id inserted into $table.", LOG_LEVEL_INFO);
            }
        }
    } catch (PDOException $e) {
        logMessage("Database error: " . $e->getMessage(), LOG_LEVEL_ERROR);
    } catch (InvalidArgumentException $e) {
        logMessage("Invalid argument: " . $e->getMessage(), LOG_LEVEL_ERROR);
    } catch (Exception $e) {
        logMessage("Unexpected error: " . $e->getMessage(), LOG_LEVEL_ERROR);
    }
}

loadData($pdo, 'accounts', $transformedAccounts);
loadData($pdo, 'vendors', $transformedVendors);
loadData($pdo, 'bank_accounts', $transformedBankAccounts);
