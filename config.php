<?php
session_start();

define("HOST", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("DB", "ts553");

try {
    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USERNAME, PASSWORD);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die;
}
