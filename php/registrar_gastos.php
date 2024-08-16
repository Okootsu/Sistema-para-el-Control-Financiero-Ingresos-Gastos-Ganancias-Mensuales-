<?php
if (!empty($_POST["enviar_gasto"])){
    // Verificar si el formulario fue enviado recientemente
    if (isset($_SESSION['ultimo_envio']) && time() - $_SESSION['ultimo_envio'] < 5) {
        echo "<script> alert('¡Registrado con exito!'); window.location.href='mostrar_datos_gastos.php'; </script>";
        exit;
    }

    // Actualizar el tiempo del último envío
    $_SESSION['ultimo_envio'] = time();

    if (empty($_POST["descripcion"]) or empty($_POST["tipo_pago"]) or empty($_POST["tasa_bcv"]) or empty($_POST["monto_dolares"]) or empty($_POST["monto_bolivares"]) or empty($_POST["fecha"])){
        echo "Los campos estan vacios";
    }else{
        $descripcion = $_POST["descripcion"];
        $tipo_pago = $_POST["tipo_pago"];
        $tasa_bcv = $_POST["tasa_bcv"];
        $monto_dolares = $_POST["monto_dolares"];
        $monto_bolivares = $_POST["monto_bolivares"];
        $fecha =date("Y/m/d",strtotime($_POST["fecha"]));
        $sql = $connect->query("INSERT INTO gastos(descripcion,tipo_pago,tasa_bcv,monto_dolares,monto_bolivares,fecha) VALUES('$descripcion','$tipo_pago','$tasa_bcv','$monto_dolares','$monto_bolivares','$fecha')");
        if ($sql) {
            echo "<script> alert('¡Registrado con exito!'); window.location.href='mostrar_datos_gastos.php'; </script>";
        }else{
            echo "<script> alert('¡Ocurrio un error intente de nuevo!'); </script>";
        }
    }
}
?>