<?php
// Incluir la conexión a la base de datos
require_once dirname(__DIR__) . '/db.php';

// Inicializar variables
$nombre = '';
$precio = '';

// Verificar si se reciben datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $precio = htmlspecialchars($_POST['precio']);

    // Validar y guardar en la base de datos
    try {
        // Ajustar la ruta de la base de datos
        $dbPath = dirname(__DIR__) . '/db/DBfacturacion.sqlite';
        echo "Ruta de la base de datos: " . $dbPath . "<br>";

        // Crear instancia de la base de datos
        $db = new Database($dbPath);
        $pdo = $db->getPDO();

        // Preparar la consulta SQL
        $stmt = $pdo->prepare('INSERT INTO articulos (nombre, precio) VALUES (:nombre, :precio)');
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Artículo guardado con éxito.<br>";
            // Redireccionar a la página de artículos después de guardar
            header('Location: ../articulo.php');
            exit;
        } else {
            echo "Error al guardar el artículo.<br>";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage() . "<br>";
    }
}
