<?php

$config = [
    'db' => [
        'host' => 'localhost',
        'port' => 5432,
        'dbname' => 'database',
        'username' => 'username',
        'password' => 'password',
    ]
];

function getDbConnection($config) {
    try {
        // Extract configuration values.
        $host = $config['db']['host'] ?? '';
        $port = $config['db']['port'] ?? '';
        $dbname = $config['db']['dbname'] ?? '';
        $username = $config['db']['username'] ?? '';
        $password = $config['db']['password'] ?? '';

        if (empty($host) || empty($port) || empty($dbname) || empty($username) || empty($password)) {
            die('Configuration error: Incomplete database configuration');
        }
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
}
