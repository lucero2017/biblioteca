<?php
require 'db_connect.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'], $_POST['autor_id'], $_POST['categoria_id'], $_POST['copias_disponibles'])) {
    $titulo = $_POST['titulo'];
    $autor_id = $_POST['autor_id'];
    $categoria_id = $_POST['categoria_id'];
    $copias_disponibles = $_POST['copias_disponibles'];

    try {
        $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor_id, categoria_id, copias_disponibles) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $autor_id, $categoria_id, $copias_disponibles]);

        $success = "Libro agregado exitosamente.";
    } catch (Exception $e) {
        $error = "Error al agregar el libro: " . $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_autor'])) {
    $nuevo_autor = $_POST['nuevo_autor'];

    try {
        $stmt = $pdo->prepare("INSERT INTO autores (nombre_autor) VALUES (?)");
        $stmt->execute([$nuevo_autor]);

        $success_autor = "Autor agregado exitosamente.";
    } catch (Exception $e) {
        $error_autor = "Error al agregar el autor: " . $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_categoria'])) {
    $nueva_categoria = $_POST['nueva_categoria'];

    try {
        $stmt = $pdo->prepare("INSERT INTO categorias (nombre_categoria) VALUES (?)");
        $stmt->execute([$nueva_categoria]);

        $success_categoria = "Categoría agregada exitosamente.";
    } catch (Exception $e) {
        $error_categoria = "Error al agregar la categoría: " . $e->getMessage();
    }
}
$autoresStmt = $pdo->query("SELECT * FROM autores");
$autores = $autoresStmt->fetchAll(PDO::FETCH_ASSOC);

$categoriasStmt = $pdo->query("SELECT * FROM categorias");
$categorias = $categoriasStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Libro</title>
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
        }
        form {
            margin-top: 30px;
            background-color: rgba(139, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        input, select {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid gold;
            background-color: transparent;
            color: white;
        }
        select {
            background-color: transparent;
            color: white;
        }
        select:hover, select:focus {
            background-color: #800000; 
            color: white; 
        }
        .button-submit {
            background-color: gold;
            border: none;
            color: black;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        .button-submit:hover {
            background-color: #FFD700;
        }
        .button-back {
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
        .button-back:hover {
            background-color: #FFD700;
        }
    </style>
</head>
<body>
    <h1>HOGWARTS</h1>
    <h2>Agregar Nuevo Libro</h2>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <label for="titulo">Título del Libro:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="autor_id">Autor:</label>
        <select id="autor_id" name="autor_id" required>
            <option value="">Seleccione un autor</option>
            <?php foreach ($autores as $autor): ?>
                <option value="<?= $autor['autor_id']; ?>"><?= $autor['nombre_autor']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" name="categoria_id" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['categoria_id']; ?>"><?= $categoria['nombre_categoria']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="copias_disponibles">Copias Disponibles:</label>
        <input type="number" id="copias_disponibles" name="copias_disponibles" required min="1">

        <button type="submit" class="button-submit">Agregar Libro</button>
    </form>
    <h3>Agregar Nuevo Autor</h3>
    <form method="POST">
        <input type="text" name="nuevo_autor" placeholder="Nombre del Autor" required>
        <button type="submit" class="button-submit">Agregar Autor</button>
    </form>
    <?php if (isset($success_autor)) echo "<p style='color:green;'>$success_autor</p>"; ?>
    <?php if (isset($error_autor)) echo "<p style='color:red;'>$error_autor</p>"; ?>
    <h3>Agregar Nueva Categoría</h3>
    <form method="POST">
        <input type="text" name="nueva_categoria" placeholder="Nombre de la Categoría" required>
        <button type="submit" class="button-submit">Agregar Categoría</button>
    </form>
    <?php if (isset($success_categoria)) echo "<p style='color:green;'>$success_categoria</p>"; ?>
    <?php if (isset($error_categoria)) echo "<p style='color:red;'>$error_categoria</p>"; ?>

    <a href="administrar-libros.php" class="button-back">Volver a Administrar Libros</a>
</body>
</html>
