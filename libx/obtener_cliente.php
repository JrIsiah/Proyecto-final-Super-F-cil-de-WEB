<?php
require_once dirname(__DIR__) . '/db.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    try {
        $db = new Database(__DIR__ . '/../db/DBfacturacion.sqlite');
        $pdo = $db->getPDO();

        $stmt = $pdo->prepare("SELECT nombre FROM clientes WHERE matricula = ?");
        $stmt->execute([$codigo]);

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            $response['success'] = true;
            $response['nombre'] = $cliente['nombre'];
        } else {
            $response['message'] = 'Cliente no encontrado';
        }
    } catch (Exception $e) {
        $response['message'] = 'Error al buscar el cliente: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Código de cliente no proporcionado';
}

echo json_encode($response);
exit;
