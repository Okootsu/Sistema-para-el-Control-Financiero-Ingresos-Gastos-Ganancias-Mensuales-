<?php
if (!empty($_POST["enviar_ingreso"])) {
    // Verificar si el formulario fue enviado recientemente
    if (isset($_SESSION['ultimo_envio']) && time() - $_SESSION['ultimo_envio'] < 5) {
        echo "<script> alert('¡Registrado con éxito!');window.location.href='mostrar_datos_ingresos.php'; </script>";
        exit;
    }

    // Actualizar el tiempo del último envío
    $_SESSION['ultimo_envio'] = time();

    if (empty($_POST["tipo_ingreso"]) || empty($_POST["tasa_bcv"]) || empty($_POST["monto_dolares"]) || empty($_POST["monto_bolivares"]) || empty($_POST["fecha"])) {
        echo "Los campos están vacíos";
    } else {
        $tipo_ingreso = $_POST["tipo_ingreso"];
        $tasa_bcv = $_POST["tasa_bcv"];
        $monto_dolares = $_POST["monto_dolares"];
        $monto_bolivares = $_POST["monto_bolivares"];
        $fecha = date("Y/m/d", strtotime($_POST["fecha"]));
        
        $sql = $connect->query("INSERT INTO ingresos(tipo_ingreso, tasa_bcv, monto_dolares, monto_bolivares, fecha) VALUES('$tipo_ingreso', '$tasa_bcv', '$monto_dolares', '$monto_bolivares', '$fecha')");
        
        if ($sql == 1) {
            echo "<script> alert('¡Registrado con éxito!'); window.location.href='mostrar_datos_ingresos.php'; </script>";
        } else {
            echo "<script> alert('¡Ocurrió un error, intente de nuevo!'); </script>";
        }
    }
}
?>