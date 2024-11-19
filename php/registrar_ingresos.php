<?php
# Verificamos si el boton del formulario de registro fue pulsado
if (!empty($_POST["enviar_ingreso"])) {
    # Verificar si el formulario fue enviado recientemente
    if (isset($_SESSION['ultimo_envio']) && time() - $_SESSION['ultimo_envio'] < 5) {
        echo "<script> alert('¡Registrado con éxito!');window.location.href='mostrar_datos_ingresos.php'; </script>";
        exit;
    }

    # Actualizar el tiempo del último envío
    $_SESSION['ultimo_envio'] = time();

    # Verificamos si alguno de los campos estan vacios
    if (empty($_POST["tipo_ingreso"]) || empty($_POST["tasa_bcv"]) || empty($_POST["monto_dolares"]) || empty($_POST["monto_bolivares"]) || empty($_POST["fecha"])) {
        echo "Los campos están vacíos";
        echo "<script> alert('¡Ocurrió un error, intente de nuevo!'); </script>";
    } else {
        # Obtenemos los datos del formulario
        $id_usuario = $_SESSION["cedula"];
        $tipo_ingreso = $_POST["tipo_ingreso"];
        $tasa_bcv = $_POST["tasa_bcv"];
        $monto_dolares = $_POST["monto_dolares"];
        $monto_bolivares = $_POST["monto_bolivares"];
        $fecha = date("Y/m/d", strtotime($_POST["fecha"]));
        
        # Sentencia SQL para almacenar el registro en la base de datos
        $sql = $connect->query("INSERT INTO ingresos(cedula, tipo_ingreso, tasa_bcv, monto_dolares, monto_bolivares, fecha) VALUES($id_usuario, '$tipo_ingreso', '$tasa_bcv', '$monto_dolares', '$monto_bolivares', '$fecha')");
        if ($sql == 1) {
            echo "<script> alert('¡Registrado con éxito!'); window.location.href='mostrar_datos_ingresos.php'; </script>";
        } else {
            echo "<script> alert('¡Ocurrió un error, intente de nuevo!'); </script>";
        }
    }
}
?>