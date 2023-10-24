<?php
// database connection
require_once 'login.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>