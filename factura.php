<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Facturas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Registro de Facturas</h1>
        <form id="facturaForm" action="libx/guardar_factura.php" method="POST">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="codigo_cliente">Código del Cliente:</label>
                <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente" required>
            </div>
            <div class="form-group">
                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" readonly>
            </div>
            <div id="articulos">
                <div class="articulo-row">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="articulo">Artículo:</label>
                            <input type="text" class="form-control articulo" name="articulos[]" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" class="form-control cantidad" name="cantidades[]" min="1" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="precio">Precio Unitario:</label>
                            <input type="number" class="form-control precio" name="precios[]" min="0.01" step="0.01" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="total">Total:</label>
                            <input type="number" class="form-control total" name="totales[]" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" id="agregarArticulo">Agregar Artículo</button>
            <div class="form-group">
                <label for="total_factura">Total a Pagar:</label>
                <input type="number" class="form-control" id="total_factura" name="total_factura" readonly>
            </div>
            <div class="form-group">
                <label for="comentario">Comentario:</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar e Imprimir Factura</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Volver Atrás</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cargar nombre del cliente al ingresar el código
            $('#codigo_cliente').on('blur', function() {
                var codigo = $(this).val();
                if (codigo) {
                    $.ajax({
                        url: 'libx/obtener_cliente.php',
                        type: 'GET',
                        data: {
                            codigo: codigo
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#nombre_cliente').val(response.nombre);
                            } else {
                                alert('Error: ' + response.message);
                                $('#nombre_cliente').val('');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error en la solicitud AJAX: ' + textStatus + ', ' + errorThrown);
                            console.log(jqXHR.responseText);
                        }
                    });
                }
            });

            // Agregar nuevo artículo
            $('#agregarArticulo').click(function() {
                var nuevoArticulo = $('.articulo-row:first').clone();
                nuevoArticulo.find('input').val('');
                $('#articulos').append(nuevoArticulo);
            });

            // Calcular totales
            $('#articulos').on('input', '.cantidad, .precio', function() {
                var row = $(this).closest('.articulo-row');
                var cantidad = parseFloat(row.find('.cantidad').val()) || 0;
                var precio = parseFloat(row.find('.precio').val()) || 0;
                row.find('.total').val((cantidad * precio).toFixed(2));

                calcularTotalFactura();
            });

            function calcularTotalFactura() {
                var total = 0;
                $('.total').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#total_factura').val(total.toFixed(2));
            }

            // Envío del formulario
            $('#facturaForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Factura guardada con éxito. Número de factura: ' + response.facturaId);
                            window.open('libx/imprimir_factura.php?facturaId=' + response.facturaId, '_blank');
                        } else {
                            alert('Error al guardar la factura: ' + response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al procesar la factura');
                        console.log(jqXHR.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>