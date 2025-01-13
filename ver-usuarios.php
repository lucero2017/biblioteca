<?php
require 'db_connect.php'; 
$usuarios = $pdo->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
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
            max-width: 800px;
            background-color: rgba(139, 0, 0, 0.8);
            border-radius: 10px;
        }

        h2 {
            color: white;
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid gold;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: gold;
            color: black;
            font-weight: bold;
        }

        td {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: gold;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #d4af37;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>
    <div class="container">
        <h2>Usuarios Registrados</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Fecha de Registro</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['usuario_id']); ?></td>
                <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                <td><?= htmlspecialchars($usuario['correo']); ?></td>
                <td><?= htmlspecialchars($usuario['telefono']); ?></td>
                <td><?= htmlspecialchars($usuario['fecha_registro']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="consulta-datos.php" class="button">Volver al Inicio</a>
    </div>
</body>
</html>
