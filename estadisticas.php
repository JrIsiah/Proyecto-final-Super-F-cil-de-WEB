<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Estadísticas de Ventas</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cantidad de Facturas Hoy</h5>
                        <p class="card-text">Número total de facturas generadas hoy.</p>
                        <h1 id="cantidadFacturas" class="text-center">Cargando...</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Dinero Cobrado Hoy</h5>
                        <p class="card-text">Cantidad total de dinero recaudado hoy.</p>
                        <h1 id="totalDinero" class="text-center">Cargando...</h1>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mt-4" onclick="window.history.back();">Volver Atrás</button>
    </div>

    <!-- Bootstrap JS y dependencias Popper.js y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script JavaScript para obtener datos -->
    <script>
        $(document).ready(function() {
            function obtenerEstadisticasVentas() {
                $.ajax({
                    url: 'libx/obtener_estadisticas.php', // Ajusta la ruta aquí
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Datos recibidos:', data); // Mostrar datos recibidos en la consola
                        $('#cantidadFacturas').text(data.cantidadFacturas);
                        $('#totalDinero').text('$' + data.totalDinero.toFixed(2));
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error); // Mostrar errores en la consola
                        $('#cantidadFacturas').text('Error al cargar');
                        $('#totalDinero').text('Error al cargar');
                    }
                });
            }

            obtenerEstadisticasVentas(); // Llamar a la función al cargar la página
        });
    </script>
</body>

</html>