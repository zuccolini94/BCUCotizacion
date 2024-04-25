<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Cotizaciones - BCU</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2 class="mt-4 mb-4">Consulta de Cotizaciones</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="moneda">Moneda:</label>
            <input type="text" class="form-control" id="moneda" name="moneda" required>
            <a href="https://www.bcu.gub.uy/Documents/cotizacion.txt" target="_blank">Lista de Monedas</a>
        </div>
        <div class="form-group">
            <label for="grupo">Grupo:</label>
            <input type="text" class="form-control" id="grupo" name="grupo" value="0" required>
        </div>
        <div class="form-group">
            <label for="fecha_desde">Fecha Desde:</label>
            <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" required>
        </div>
        <div class="form-group">
            <label for="fecha_hasta">Fecha Hasta:</label>
            <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" required>
        </div>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>

    <hr>

    <!-- Muestro resultados -->
    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['moneda']) && isset($_POST['grupo']) && isset($_POST['fecha_desde']) && isset($_POST['fecha_hasta'])) {
            $moneda = $_POST['moneda'];
            $grupo = $_POST['grupo'];
            $fecha_desde = $_POST['fecha_desde'];
            $fecha_hasta= $_POST['fecha_hasta'];
            obtenerCotizacionesBCU($fecha_desde, $fecha_hasta, $grupo, $moneda);
        }
    }
    
    function obtenerCotizacionesBCU($fecha_desde, $fecha_hasta, $grupo, $moneda){
      
       $arrEntrada = [
        'Entrada' => [
              'FechaDesde' => $fecha_desde,
              'FechaHasta' => $fecha_hasta,
              'Grupo'      => $grupo,
              'Moneda'     => ['item' => $moneda]
            ]
      ];
      
      $clientWS = new SoapClient('https://cotizaciones.bcu.gub.uy/wscotizaciones/servlet/awsbcucotizaciones?wsdl');
      $responseWS = $clientWS->Execute($arrEntrada);
      print_r($responseWS->Salida->datoscotizaciones);
    }
    
    ?>

</div>

</body>
</html>
