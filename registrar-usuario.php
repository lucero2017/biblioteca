<?php
require 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, telefono) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $correo, $telefono]);
        $success = "Usuario registrado exitosamente";
    } catch (PDOException $e) {
        $error = "Error al registrar usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
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
            margin-bottom: 20px;
        }
        form {
            background-color: #8B0000;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin: 0 auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid gold;
            border-radius: 5px;
            background-color: white;
            color: black;
        }
        button {
            width: 100%;
            background-color: gold;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #FFD700;
        }
        a {
            color: gold;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>
    <h2>Registrar Usuario</h2>
    <?php 
        if (isset($success)) echo "<p style='color:green;'>$success</p>"; 
        if (isset($error)) echo "<p style='color:red;'>$error</p>"; 
    ?>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required>
        <button type="submit">Registrar</button>
    </form>
    <p><a href="consulta-datos.php">Volver al Inicio</a></p>
</body>
</html>
