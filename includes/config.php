<?php
session_start();

$host = 'localhost';
<<<<<<< HEAD
$dbname = 'resume_studio';
=======
$dbname = 'resume_builder_db';
>>>>>>> 06aa8ac27dca1204de532104ff7d24f9fb480ba8
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>