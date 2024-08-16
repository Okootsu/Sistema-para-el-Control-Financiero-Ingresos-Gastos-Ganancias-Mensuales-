<?php
include ("conexion_db.php");
$id = $_GET["id"];

$sql = $connect->query("SELECT * FROM ingresos WHERE id_ingreso = $id");

$tipo_ingreso;
$tasa_bcv;
$monto_dolares;
$monto_bolivares;
$fecha;

while ($row = $sql->fetch_array()) {
    $tipo_ingreso = $row["tipo_ingreso"];
    $tasa_bcv = $row["tasa_bcv"];
    $monto_dolares = $row["monto_dolares"];
    $monto_bolivares = $row["monto_bolivares"];
    $fecha = $row["fecha"];
}

if (!empty($_POST["enviar_ingreso"])) {
    if (empty($_POST["tipo_ingreso"]) or empty($_POST["tasa_bcv"]) or empty($_POST["monto_dolares"]) or empty($_POST["monto_bolivares"]) or empty($_POST["fecha"])){
        echo "Los campos estan vacios";
    }else{
        $tipo_ingreso = $_POST["tipo_ingreso"];
        $tasa_bcv = $_POST["tasa_bcv"];
        $monto_dolares = $_POST["monto_dolares"];
        $monto_bolivares = $_POST["monto_bolivares"];
        $fecha = date("Y/m/d",strtotime($_POST["fecha"])) ;
        $sql = $connect->query("UPDATE ingresos SET tipo_ingreso='$tipo_ingreso' ,tasa_bcv=$tasa_bcv ,monto_dolares=$monto_dolares ,monto_bolivares=$monto_bolivares ,fecha='$fecha'  WHERE id_ingreso = $id");
        header("location:mostrar_datos_ingresos.php");
    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Ingreso</title>
</head>

<header>
    <div class="cabecera">
        <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
    </div>
</header>

<body>
    <div class="contenedor">
        <form method="POST">
            <p>MODIFICAR REGISTRO INGRESOS</p>
            <p>Tipo de Ingreso</p>
            <input type="text" name="tipo_ingreso" placeholder="Ejemplo: Pto de Venta,etc"  value="<?=$tipo_ingreso?>" required>
            <p>Tasa BCV</p>
            <input type="number" name="tasa_bcv" step="0.01" value="<?=$tasa_bcv?>" required>
            <p>Monto en Dolares</p>
            <input type="number" name="monto_dolares" step="0.01" value="<?=$monto_dolares?>" required>
            <p>Monto en Bolivares</p>
            <input type="number" name="monto_bolivares" step="0.01" value="<?=$monto_bolivares?>" required>
            <p>Fecha</p>
            <input type="date" name="fecha" value="<?=$fecha?>" required>
            <div class="botones_accion">
                <input class="btn"  id="btn_enviar_datos_1" name="enviar_ingreso" type="submit" value="Modificar">
                <a class="btn cerrar" href="../index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>

<footer>
	<div class="footer_main">
		<h3>Sistema para el Control Financiero</h3>
		<b>© Copyright  2024</b>
	</div>
</footer>

</html>