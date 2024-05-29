<?php

const MAX_LOG_RETENTION_DAYS = 15;

const LOG_LEVEL_DEBUG = 'DEBUG';
const LOG_LEVEL_INFO = 'INFO';
const LOG_LEVEL_WARNING = 'WARNING';
const LOG_LEVEL_ERROR = 'ERROR';
const LOG_LEVEL_CRITICAL = 'CRITICAL';

function logMessage($message, $logLevel = LOG_LEVEL_INFO) {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$logLevel] $message\n";
    $logFilePath = 'logs/app.log';

    // Check if the log file exists, otherwise create it.
    if (!file_exists(dirname($logFilePath))) {
        if (!mkdir(dirname($logFilePath), 0777, true)) {
            error_log("Unable to create log directory: " . dirname($logFilePath));
            return;
        }
    }
    $result = file_put_contents($logFilePath, $logEntry, FILE_APPEND);
    if ($result === false) {
        error_log("Unable to write to log file: $logFilePath");
    }
}

function purgeOldLogs() {
    $logFilePath = '/logs/app.log';
    if (file_exists($logFilePath) && filesize($logFilePath) > 0) {
        $maxRetentionTimestamp = strtotime('-' . MAX_LOG_RETENTION_DAYS . ' days');
        $logEntries = file($logFilePath, FILE_IGNORE_NEW_LINES);

        // Filter log entries to only keep logs within retention timeframe.
        $filteredLogEntries = array_filter($logEntries, function ($logEntry) use ($maxRetentionTimestamp) {
            $timestamp = strtotime(substr($logEntry, 1, 15)); // Extract timestamp from the logs
            return $timestamp >= $maxRetentionTimestamp;
        });
        // Rewrite log file with filtered log entries.
        file_put_contents($logFilePath, implode("\n", $filteredLogEntries));
    } else {
        logMessage("Log file is empty or does not exist.", LOG_LEVEL_WARNING);
    }
}
// Purge old log entries on script execution.
purgeOldLogs();

function errorHandler($errstr, $errfile, $errline) {
    if (str_contains($errstr, 'extract') || str_contains($errstr, 'transform') || str_contains($errstr, 'load')) {
        logMessage("ETL Error: $errstr in $errfile on line $errline", LOG_LEVEL_ERROR);
    } else {
        logMessage("Error: $errstr in $errfile on line $errline");
    }
}

function exceptionHandler($exception, $logLevel = LOG_LEVEL_ERROR) {
    logMessage("Exception: " . $exception->getMessage(), $logLevel);
}

set_error_handler('errorHandler');
set_exception_handler('exceptionHandler');
