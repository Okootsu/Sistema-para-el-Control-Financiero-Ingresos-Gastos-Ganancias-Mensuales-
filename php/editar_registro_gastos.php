<?php
include ("conexion_db.php");
$id = $_GET["id"];

$descripcion;
$tipo_pago;
$tasa_bcv;
$monto_dolares;
$monto_bolivares;
$fecha;

$sql = $connect->query("SELECT * FROM gastos WHERE id_gasto = $id");

if ($sql) {     
    while ($row = $sql->fetch_array()) {
        $id = $row["id_gasto"];
        $descripcion = $row["descripcion"];
        $tipo_pago = $row["tipo_pago"];
        $tasa_bcv = $row["tasa_bcv"];
        $monto_dolares = $row["monto_dolares"];
        $monto_bolivares = $row["monto_bolivares"];
        $fecha = $row["fecha"];
    }
}

if (!empty($_POST["enviar_gasto"])){
    if (empty($_POST["descripcion"]) or empty($_POST["tipo_pago"]) or empty($_POST["tasa_bcv"]) or empty($_POST["monto_dolares"]) or empty($_POST["monto_bolivares"]) or empty($_POST["fecha"])){
        echo "Los campos estan vacios";
    }else{
        $descripcion = $_POST["descripcion"];
        $tipo_pago = $_POST["tipo_pago"];
        $tasa_bcv = $_POST["tasa_bcv"];
        $monto_dolares = $_POST["monto_dolares"];
        $monto_bolivares = $_POST["monto_bolivares"];
        $fecha =date("Y/m/d",strtotime($_POST["fecha"]));
        $sql = $connect->query("UPDATE gastos SET descripcion='$descripcion',tipo_pago='$tipo_pago',tasa_bcv=$tasa_bcv,monto_dolares=$monto_dolares,monto_bolivares=$monto_bolivares,fecha='$fecha' WHERE id_gasto = $id");
        header("location:mostrar_datos_gastos.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Gasto</title>
</head>

<header>
    <div class="cabecera">
        <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
    </div>
</header>

<body>
    
    <div class="contenedor">
        <form method="POST">
            <p>MODIFICAR REGISTRO GASTO</p>
            <p>Descripcion</p>
            <input name="descripcion" type="text" placeholder="Ejemplo: Factura,SENIAT, etc" value="<?=$descripcion?>" required>
            <p>Tipo de Pago</p>
            <input name="tipo_pago" type="text" placeholder="Ejemplo: Transferencia, Divisa, etc" value="<?=$tipo_pago?>" required>
            <p>Tasa BCV</p>
            <input name="tasa_bcv" type="number" step="0.01" value="<?=$tasa_bcv?>" required>
            <p>Monto en Dolares</p>
            <input name="monto_dolares" type="number" step="0.01" value="<?=$monto_dolares?>" required>
            <p>Monto en Bolivares</p>
            <input name="monto_bolivares" type="number" step="0.01" value="<?=$monto_bolivares?>" required>
            <p>Fecha</p>
            <input name="fecha" type="date" value="<?=$fecha?>" required>
            <div class="botones_accion">
                <input class="btn" name="enviar_gasto" id="btn_enviar_datos_2" type="submit" value="Enviar">
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