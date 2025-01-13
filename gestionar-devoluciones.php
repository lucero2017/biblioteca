<?php
require 'db_connect.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prestamo_id'])) {
    $prestamo_id = $_POST['prestamo_id'];

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("SELECT libro_id FROM prestamos WHERE prestamo_id = ?");
        $stmt->execute([$prestamo_id]);
        $prestamo = $stmt->fetch();

        if ($prestamo) {
            $pdo->prepare("UPDATE libros SET copias_disponibles = copias_disponibles + 1 WHERE libro_id = ?")
                ->execute([$prestamo['libro_id']]);
            $pdo->prepare("DELETE FROM prestamos WHERE prestamo_id = ?")->execute([$prestamo_id]);

            $pdo->commit();
            $success = "Devolución registrada exitosamente.";
        } else {
            throw new Exception("Préstamo no encontrado.");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error al gestionar devolución: " . $e->getMessage();
    }
}
$query = "
    SELECT 
        p.prestamo_id,
        u.usuario_id, 
        u.nombre AS usuario, 
        u.correo, 
        (SELECT COUNT(*) FROM prestamos p2 WHERE p2.usuario_id = u.usuario_id) AS cantidad_libros_prestados,
        l.titulo AS libro, 
        c.nombre_categoria AS categoria, 
        p.fecha_prestamo 
    FROM usuarios u
    LEFT JOIN prestamos p ON u.usuario_id = p.usuario_id
    LEFT JOIN libros l ON p.libro_id = l.libro_id
    LEFT JOIN categorias c ON l.categoria_id = c.categoria_id
    WHERE p.prestamo_id IS NOT NULL  -- Filtrar solo usuarios con préstamos
    ORDER BY u.usuario_id, p.fecha_prestamo;
";

$usuarios = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Préstamos</title>
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
            max-width: 900px;
            background-color: rgba(139, 0, 0, 0.8);
            border-radius: 10px;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: white;
        }

        table, th, td {
            border: 1px solid gold;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: gold;
            color: black;
        }

        .button {
            display: inline-block;
            margin-top: 10px;
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
            background-color: #FFD700;
        }

        .devuelto-btn {
            padding: 5px 10px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .devuelto-btn:hover {
            background-color: #c9302c;
        }

        .no-records {
            color: red;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <h1>Detalles de Préstamos</h1>
    <div class="container">
        <?php 
            if (isset($success)) echo "<p style='color:green;'>$success</p>"; 
            if (isset($error)) echo "<p style='color:red;'>$error</p>"; 
        ?>
        
        <?php if (empty($usuarios)): ?>
            <p class="no-records">No existen préstamos registrados.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Cantidad de Libros Prestados</th>
                    <th>Libro</th>
                    <th>Categoría</th>
                    <th>Fecha de Préstamo</th>
                    <th>Acción</th>
                </tr>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['usuario_id']); ?></td>
                    <td><?= htmlspecialchars($usuario['usuario']); ?></td>
                    <td><?= htmlspecialchars($usuario['correo']); ?></td>
                    <td><?= htmlspecialchars($usuario['cantidad_libros_prestados']); ?></td>
                    <td><?= htmlspecialchars($usuario['libro'] ?: 'N/A'); ?></td>
                    <td><?= htmlspecialchars($usuario['categoria'] ?: 'N/A'); ?></td>
                    <td><?= htmlspecialchars($usuario['fecha_prestamo'] ?: 'N/A'); ?></td>
                    <td>
                        <?php if ($usuario['prestamo_id']): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="prestamo_id" value="<?= $usuario['prestamo_id']; ?>">
                                <button type="submit" class="devuelto-btn">Devuelto</button>
                            </form>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <a href="consulta-datos.php" class="button">Volver al Inicio</a>
    </div>
</body>
</html>
