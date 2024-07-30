<?php
// Iniciar el almacenamiento en buffer de salida
ob_start();

// Incluir la conexión a la base de datos
require_once dirname(__DIR__) . '/db.php';

// Inicializar variables
$matricula = '';
$nombre = '';
$error_message = '';

// Verificar si se reciben datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $matricula = htmlspecialchars($_POST['matricula']);
    $nombre = htmlspecialchars($_POST['nombre']);

    // Validar y guardar en la base de datos
    try {
        // Ajustar la ruta de la base de datos
        $dbPath = dirname(__DIR__) . '/db/DBfacturacion.sqlite';

        // Crear instancia de la base de datos
        $db = new Database($dbPath);
        $pdo = $db->getPDO();

        // Preparar la consulta SQL
        $stmt = $pdo->prepare('INSERT INTO clientes (matricula, nombre) VALUES (:matricula, :nombre)');
        $stmt->bindParam(':matricula', $matricula);
        $stmt->bindParam(':nombre', $nombre);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redireccionar a la página de clientes después de guardar
            header('Location: ../cliente.php');
            ob_end_flush();
            exit;
        } else {
            $error_message = "Error al guardar el cliente.";
        }
    } catch (PDOException $e) {
        $error_message = "Error de conexión: " . $e->getMessage();
    }
}

// Si llegamos aquí, hubo un error o no se envió el formulario
ob_end_flush();

// Mostrar el mensaje de error en la misma página si es necesario
if ($error_message) {
    echo "<p>$error_message</p>";
}
