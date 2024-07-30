<?php
require_once dirname(__DIR__) . '/db.php';

// Establecer la zona horaria a la de República Dominicana
date_default_timezone_set('America/Santo_Domingo');

// Obtener fecha actual en formato YYYY-MM-DD
$fechaHoy = date('Y-m-d');

try {
    // Crear instancia de la base de datos
    $db = new Database(dirname(__DIR__) . '/db/DBfacturacion.sqlite');
    $pdo = $db->getPDO();

    // Consulta para obtener la cantidad de facturas hoy
    $stmt = $pdo->prepare("SELECT COUNT(*) AS cantidadFacturas FROM facturas WHERE fecha = ?");
    $stmt->execute([$fechaHoy]);
    $cantidadFacturas = $stmt->fetchColumn();

    // Consulta para obtener el total de dinero cobrado hoy
    $stmt = $pdo->prepare("SELECT SUM(total) AS totalDinero FROM facturas WHERE fecha = ?");
    $stmt->execute([$fechaHoy]);
    $totalDinero = $stmt->fetchColumn();

    // Preparar datos para respuesta JSON
    $response = [
        'cantidadFacturas' => $cantidadFacturas,
        'totalDinero' => (float) $totalDinero // Convertir a float para asegurar dos decimales en el JSON
    ];

    // Devolver respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    // Manejar error de conexión a la base de datos
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => 'Error al conectar con la base de datos: ' . $e->getMessage()]);
    exit;
}
