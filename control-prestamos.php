<?php
require 'db_connect.php';

// Registrar un préstamo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $libro_id = $_POST['libro_id'];
    $fecha_devolucion = $_POST['fecha_devolucion'];

    try {
        // Verificar disponibilidad del libro
        $stmt = $pdo->prepare("SELECT copias_disponibles FROM libros WHERE libro_id = ?");
        $stmt->execute([$libro_id]);
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($libro && $libro['copias_disponibles'] > 0) {
            // Insertar préstamo
            $stmt = $pdo->prepare("
                INSERT INTO prestamos (usuario_id, libro_id, fecha_devolucion) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$usuario_id, $libro_id, $fecha_devolucion]);

            // Actualizar disponibilidad del libro
            $stmt = $pdo->prepare("
                UPDATE libros SET copias_disponibles = copias_disponibles - 1 WHERE libro_id = ?
            ");
            $stmt->execute([$libro_id]);

            $success = "Préstamo registrado exitosamente.";
        } else {
            $error = "No hay copias disponibles para este libro.";
        }
    } catch (PDOException $e) {
        $error = "Error al registrar préstamo: " . $e->getMessage();
    }
}

// Obtener usuarios y libros
$usuarios = $pdo->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
$libros = $pdo->query("SELECT * FROM libros WHERE copias_disponibles > 0")->fetchAll(PDO::FETCH_ASSOC);

// Buscar préstamos
$search = $_GET['cantidad_libros'] ?? null;
$searchFechaPrestamo = $_GET['fecha_prestamo'] ?? null;
$searchFechaDevolucion = $_GET['fecha_devolucion'] ?? null;

$searchQuery = "";
if ($search) {
    $searchQuery = "HAVING COUNT(p.prestamo_id) = " . (int)$search;
}

if ($searchFechaPrestamo) {
    $searchQuery .= " AND p.fecha_prestamo = '$searchFechaPrestamo'";
}

if ($searchFechaDevolucion) {
    $searchQuery .= " AND p.fecha_devolucion = '$searchFechaDevolucion'";
}

// Consulta para agrupar y concatenar títulos y autores
$prestamos = $pdo->query("
    SELECT u.nombre AS usuario, 
           COUNT(p.prestamo_id) AS cantidad, 
           GROUP_CONCAT(l.titulo ORDER BY l.titulo SEPARATOR ', ') AS libros, 
           GROUP_CONCAT(a.nombre_autor ORDER BY a.nombre_autor SEPARATOR ', ') AS autores
    FROM prestamos p
    JOIN usuarios u ON p.usuario_id = u.usuario_id
    JOIN libros l ON p.libro_id = l.libro_id
    JOIN autores a ON l.autor_id = a.autor_id
    GROUP BY u.usuario_id, u.nombre
    $searchQuery
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Préstamos</title>
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
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }
        input, select {
            background-color: #D32F2F;
            color: white;
        }
        button {
            background-color: gold;
            color: white;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
        }
        button:hover {
            background-color: #FFD700;
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
        table {
            margin: 20px auto;
            background-color: #8B0000;
            color: white;
            border-collapse: collapse;
            width: 80%;
        }
        table th, table td {
            border: 1px solid gold;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: gold;
            color: #8B0000;
        }
        .search-bar {
            margin: 20px auto;
            width: 80%;
        }
        .search-bar input {
            width: calc(100% - 100px);
            display: inline-block;
        }
        .search-bar button {
            width: 100px;
            display: inline-block;
        }
        .search-bar label {
            color: white;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>
    <h2>Control de Préstamos</h2>
    <?php 
        if (isset($success)) echo "<p style='color:green;'>$success</p>"; 
        if (isset($error)) echo "<p style='color:red;'>$error</p>"; 
    ?>
    <form method="POST" action="">
        <label>Usuario:</label>
        <select name="usuario_id" required>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= $usuario['usuario_id'] ?>"><?= $usuario['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
        <label>Libro:</label>
        <select name="libro_id" required>
            <?php foreach ($libros as $libro): ?>
                <option value="<?= $libro['libro_id'] ?>"><?= $libro['titulo'] ?></option>
            <?php endforeach; ?>
        </select>
        <label>Fecha de Devolución:</label>
        <input type="date" name="fecha_devolucion" required>
        <button type="submit">Registrar Préstamo</button>
    </form>

    <div class="search-bar">
        <form method="GET" action="">
            <label for="cantidad_libros">Buscar por cantidad de libros:</label>
            <input type="number" name="cantidad_libros" placeholder="Buscar por cantidad de libros" value="<?= $search ?? '' ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="search-bar">
        <form method="GET" action="">
            <label for="fecha_prestamo">Buscar por fecha de préstamo:</label>
            <input type="date" name="fecha_prestamo" value="<?= $searchFechaPrestamo ?? '' ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="search-bar">
        <form method="GET" action="">
            <label for="fecha_devolucion">Buscar por fecha de devolución:</label>
            <input type="date" name="fecha_devolucion" value="<?= $searchFechaDevolucion ?? '' ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <h3>Listado de Préstamos</h3>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Cantidad de Libros</th>
                <th>Libros</th>
                <th>Autores</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($prestamos): ?>
                <?php foreach ($prestamos as $prestamo): ?>
                    <tr>
                        <td><?= $prestamo['usuario'] ?></td>
                        <td><?= $prestamo['cantidad'] ?></td>
                        <td><?= $prestamo['libros'] ?></td>
                        <td><?= $prestamo['autores'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No se encontraron resultados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
