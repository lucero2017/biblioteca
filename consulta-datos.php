<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOGWARTS - Página Principal</title>
    <style>
        body {
            background-image: url('harry.png');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }

        h1 {
            color: gold;
            font-size: 3rem;
            margin-top: 20px;
            text-shadow: 2px 2px 4px black;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
            background-color: rgba(139, 0, 0, 0.8);
            border-radius: 10px;
        }

        .button {
            display: block;
            width: 100%;
            margin: 15px 0;
            padding: 15px;
            font-size: 16px;
            color: white;
            background-color: gold;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
        }

        .button:hover {
            background-color: #d4af37;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>
    <div class="container">
        <h2>Bienvenido, <?= htmlspecialchars($_SESSION['username']); ?></h2>
        <a href="registrar-usuario.php" class="button">Registrar Usuario</a>
        <a href="administrar-libros.php" class="button">Administrar Libros</a>
        <a href="control-prestamos.php" class="button">Control de Préstamos</a>
        <a href="autores-categorias.php" class="button">Autores y Categorías</a>
        <a href="gestionar-devoluciones.php" class="button">Gestionar Devoluciones</a>
        <a href="ver-usuarios.php" class="button">Ver Usuarios</a>
    </div>
</body>
</html>
