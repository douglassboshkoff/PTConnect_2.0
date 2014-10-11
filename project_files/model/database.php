<?php
$dsn = 'mysql:host=localhost;dbname=pt_connect';
$db_username = 'username';
$db_password = 'password';

try {
    $db = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('../homepage/database_error.php');
    exit();
}
?>