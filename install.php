<?php

require __DIR__ . '/config.php';

$pdo = new \PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
    DB_USER,
    DB_PASS
);

try {
    $sql = file_get_contents('dump.sql');

    $query = $pdo->prepare($sql);

    $query->execute();
} catch (\Exception $e) {
    $e->getMessage() . "\n";
}