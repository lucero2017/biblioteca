<?php
require 'db_connect.php'; 

$autores = $pdo->query("SELECT * FROM autores")->fetchAll(PDO::FETCH_ASSOC);
$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores y Categorías</title>
    <style>
        body {
            background-image: url('harry.png');
            background-size: cover;
            background-attachment: fixed;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 3rem;
            color: gold;
            margin-top: 20px;
            text-shadow: 2px 2px 4px #000;
        }
        h2 {
            font-size: 2rem;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto 40px auto;
            border-collapse: collapse;
            background-color: #8B0000;
            color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }
        table th, table td {
            border: 1px solid white;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: gold;
            color: white;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #A52A2A;
        }
        table tr:hover {
            background-color: #D32F2F;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: gold;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
        }
        a:hover {
            background-color: #FFD700;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>

    <h2>Autores</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre del Autor</th>
        </tr>
        <?php foreach ($autores as $autor): ?>
        <tr>
            <td><?= $autor['autor_id'] ?></td>
            <td><?= $autor['nombre_autor'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Categorías</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre de la Categoría</th>
        </tr>
        <?php foreach ($categorias as $categoria): ?>
        <tr>
            <td><?= $categoria['categoria_id'] ?></td>
            <td><?= $categoria['nombre_categoria'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="consulta-datos.php">Volver al Inicio</a>
</body>
</html>
