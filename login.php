<?php 
session_start();
require 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM administradores WHERE usuario = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $admin['usuario'];
        header('Location: consulta-datos.php'); 
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOGWARTS - Inicio de Sesión</title>
    <style>
        body {
            background-image: url('harry.png');
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            font-size: 3rem;
            color: gold;
            margin-top: 30px;
            text-shadow: 2px 2px 4px black;
        }
        h2 {
            text-align: center;
            font-size: 2rem;
            margin: 20px 0;
            text-shadow: 1px 1px 2px black;
        }
        form {
            max-width: 400px;
            margin: 50px auto;
            background-color: #8B0000;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: white;
            font-size: 1rem;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid gold;
            border-radius: 5px;
            background-color: #A52A2A;
            color: white;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: gold;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
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
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>
    <h2>Inicio de Sesión</h2>

    <?php if (isset($error)) echo "<p style='color:red; text-align: center;'>$error</p>"; ?>

    <form method="POST" action="">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Iniciar Sesión</button>
    </form>

    <p>
        <a href="registro.php">Agregar usuario nuevo</a>
    </p>
</body>
</html>
