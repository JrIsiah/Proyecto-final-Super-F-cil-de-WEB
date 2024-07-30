<?php
require_once dirname(__DIR__) . '/db.php';

// Verificar si se ha proporcionado un ID de factura válido
if (isset($_GET['facturaId']) && !empty($_GET['facturaId'])) {
    $facturaId = $_GET['facturaId'];

    try {
        // Obtener instancia de la base de datos
        $db = new Database(dirname(__DIR__) . '/db/DBfacturacion.sqlite');
        $pdo = $db->getPDO();

        // Obtener información de la factura
        $stmt = $pdo->prepare("SELECT * FROM facturas WHERE id = ?");
        $stmt->execute([$facturaId]);
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtener detalles de la factura
        $stmt = $pdo->prepare("SELECT * FROM detalle_factura WHERE factura_id = ?");
        $stmt->execute([$facturaId]);
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si se encontró la factura
        if (!$factura) {
            die("Factura no encontrada.");
        }
    } catch (PDOException $e) {
        die("Error al obtener la factura: " . $e->getMessage());
    }
} else {
    die("ID de factura no válido.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Imprimir Factura</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('/img/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .factura {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .factura-header,
        .factura-footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .factura-header h1 {
            margin-bottom: 20px;
            font-weight: 700;
        }

        .factura-body table {
            width: 100%;
            border-collapse: collapse;
        }

        .factura-body th,
        .factura-body td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }

        .factura-body th {
            background-color: #f8f9fa;
        }

        .factura-body tfoot {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="factura">
        <div class="factura-header">
            <h1>Factura <i class="fas fa-file-invoice"></i></h1>
            <p><strong>Fecha:</strong> <?= htmlspecialchars($factura['fecha']) ?></p>
            <p><strong>Código del Cliente:</strong> <?= htmlspecialchars($factura['codigo_cliente']) ?></p>
            <p><strong>Nombre del Cliente:</strong> <?= htmlspecialchars($factura['nombre_cliente']) ?></p>
        </div>
        <div class="factura-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $detalle) : ?>
                        <tr>
                            <td><?= htmlspecialchars($detalle['articulo']) ?></td>
                            <td><?= htmlspecialchars($detalle['cantidad']) ?></td>
                            <td><?= htmlspecialchars($detalle['precio']) ?></td>
                            <td><?= htmlspecialchars($detalle['total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Total a Pagar:</td>
                        <td><?= htmlspecialchars($factura['total']) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="factura-footer">
            <p><strong>Comentario:</strong> <?= htmlspecialchars($factura['comentario']) ?></p>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>