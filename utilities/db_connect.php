<?php

$INCLUDE_PATH = require "../includePath.php";
require_once "$INCLUDE_PATH/envConfig.php";

try {
    $host = DB_HOST;
    $db = DB_NAME;
    $chrs = DB_CHARSET;

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$chrs", DB_USER, DB_PASSWORD, DB_OPTS);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>