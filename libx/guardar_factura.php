<?php
require_once dirname(__DIR__) . '/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener instancia de la base de datos
        $db = new Database(dirname(__DIR__) . '/db/DBfacturacion.sqlite');
        $pdo = $db->getPDO();

        // Iniciar transacción
        $pdo->beginTransaction();

        // Insertar factura
        $stmt = $pdo->prepare("INSERT INTO facturas (fecha, codigo_cliente, nombre_cliente, total, comentario) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['fecha'],
            $_POST['codigo_cliente'],
            $_POST['nombre_cliente'],
            $_POST['total_factura'],
            $_POST['comentario']
        ]);

        // Obtener el ID de la factura insertada
        $facturaId = $pdo->lastInsertId();

        // Insertar detalles de la factura
        $stmt = $pdo->prepare("INSERT INTO detalle_factura (factura_id, articulo, cantidad, precio, total) VALUES (?, ?, ?, ?, ?)");

        foreach ($_POST['articulos'] as $index => $articulo) {
            $stmt->execute([
                $facturaId,
                $articulo,
                $_POST['cantidades'][$index],
                $_POST['precios'][$index],
                $_POST['totales'][$index]
            ]);
        }

        // Confirmar transacción
        $pdo->commit();

        // Devolver respuesta JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'facturaId' => $facturaId]);
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $pdo->rollBack();
        // Devolver respuesta JSON de error
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error al procesar la factura: ' . $e->getMessage()]);
    }
}
