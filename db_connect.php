<?php
$host = 'dxptk.h.filess.io';  
$dbname = 'biblioteca_gradually';  
$username = 'biblioteca_gradually';
$password = 'c8eae234af9901a02ad4024f519bf7dab0b3cdff';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
    exit();
}
?>

