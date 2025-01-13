<?php
require 'db_connect.php'; 
$numero_copias = isset($_GET['numero_copias']) ? intval($_GET['numero_copias']) : null;
if ($numero_copias !== null) {
    $stmt = $pdo->prepare("
        SELECT 
            libros.libro_id,
            libros.titulo,
            autores.nombre_autor AS autor,
            categorias.nombre_categoria AS categoria,
            libros.copias_disponibles
        FROM libros
        INNER JOIN autores ON libros.autor_id = autores.autor_id
        INNER JOIN categorias ON libros.categoria_id = categorias.categoria_id
        WHERE libros.copias_disponibles = ?
    ");
    $stmt->execute([$numero_copias]);
} else {
    $stmt = $pdo->query("
        SELECT 
            libros.libro_id,
            libros.titulo,
            autores.nombre_autor AS autor,
            categorias.nombre_categoria AS categoria,
            libros.copias_disponibles
        FROM libros
        INNER JOIN autores ON libros.autor_id = autores.autor_id
        INNER JOIN categorias ON libros.categoria_id = categorias.categoria_id
    ");
}
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
$prestamosPorCategoriaStmt = $pdo->query("
    SELECT 
        categorias.nombre_categoria AS categoria,
        COUNT(prestamos.prestamo_id) AS cantidad_prestamos
    FROM prestamos
    INNER JOIN libros ON prestamos.libro_id = libros.libro_id
    INNER JOIN categorias ON libros.categoria_id = categorias.categoria_id
    GROUP BY categorias.nombre_categoria
");
$prestamosPorCategoria = $prestamosPorCategoriaStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Libros</title>
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
            font-size: 4rem;
            color: gold;
            margin-top: 20px;
            text-shadow: 2px 2px 4px #000;
        }
        h2 {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 20px;
        }
        h3 {
            font-size: 2rem;
            color: white;
            margin-top: 20px;
        }
        table {
            margin: 0 auto;
            background-color: #8B0000;
            border-collapse: collapse;
            width: 80%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }
        th, td {
            border: 1px solid gold;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: gold;
            color: white;
        }
        td {
            color: white;
        }
        a, .button {
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
        a:hover, .button:hover {
            background-color: #FFD700;
        }
        form {
            margin-top: 20px;
        }
        input[type="number"], input[type="submit"] {
            padding: 10px;
            font-size: 1rem;
            margin: 5px;
        }
        input[type="submit"] {
            background-color: gold;
            border: none;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #FFD700;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>
    <h2>Administrar Libros Disponibles</h2>

    <form method="GET" action="">
        <label for="numero_copias">Buscar por número de copias:</label>
        <input type="number" id="numero_copias" name="numero_copias" min="1" placeholder="Cantidad de copias" required>
        <input type="submit" value="Buscar">
    </form>

    <h3>Libros Disponibles</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Categoría</th>
            <th>Copias Disponibles</th>
        </tr>
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
            <tr>
                <td><?= $libro['libro_id'] ?></td>
                <td><?= $libro['titulo'] ?></td>
                <td><?= $libro['autor'] ?></td>
                <td><?= $libro['categoria'] ?></td>
                <td><?= $libro['copias_disponibles'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron libros con la cantidad especificada.</td>
            </tr>
        <?php endif; ?>
    </table>

    <h3>Cantidad de Préstamos por Categoría</h3>
    <table>
        <tr>
            <th>Categoría</th>
            <th>Cantidad de Préstamos</th>
        </tr>
        <?php if (!empty($prestamosPorCategoria)): ?>
            <?php foreach ($prestamosPorCategoria as $categoria): ?>
            <tr>
                <td><?= $categoria['categoria'] ?></td>
                <td><?= $categoria['cantidad_prestamos'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No se encontraron resultados.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="agregar-libro.php" class="button">Agregar Nuevo Libro</a>
    <a href="consulta-datos.php" class="button">Volver al Inicio</a>
</body>
</html>
