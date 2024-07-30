<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Sistema de Registro de Ventas</h1>
            <div>
                <span class="mr-2">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="btn btn-secondary btn-sm">Cerrar sesión</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Registro de Clientes</h5>
                        <p class="card-text">Administra los clientes registrados en el sistema.</p>
                        <a href="cliente.php" class="btn btn-primary">Ir a Clientes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Registro de Artículos</h5>
                        <p class="card-text">Administra los artículos disponibles para la venta.</p>
                        <a href="articulo.php" class="btn btn-primary">Ir a Artículos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Registro de Facturas</h5>
                        <p class="card-text">Genera y administra las facturas de venta.</p>
                        <a href="factura.php" class="btn btn-primary">Ir a Facturas</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Estadísticas</h5>
                        <p class="card-text">Visualiza estadísticas y reportes de ventas.</p>
                        <a href="estadisticas.php" class="btn btn-primary">Ver Estadísticas</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Instalación de Base de Datos</h5>
                        <p class="card-text">Haz clic en el botón para instalar la base de datos.</p>
                        <form action="db.php" method="post">
                            <button type="submit" class="btn btn-danger">Instalar Base de Datos</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias Popper.js y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>