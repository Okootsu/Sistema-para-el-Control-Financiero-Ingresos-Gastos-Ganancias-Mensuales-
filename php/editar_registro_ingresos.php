<?php
# Vinculamos la conexion a la base de datos
include ("conexion_db.php");

# Obtenemos el id del registro del ingreso por la url
$id = $_GET["id"];

# Realizamos la consulta a la base de datos
$sql = $connect->query("SELECT * FROM ingresos WHERE id_ingreso = $id");

# Almacenamos los resultado en las variables
while ($row = $sql->fetch_array()) {
    $tipo_ingreso = $row["tipo_ingreso"];
    $tasa_bcv = $row["tasa_bcv"];
    $monto_dolares = $row["monto_dolares"];
    $monto_bolivares = $row["monto_bolivares"];
    $fecha = $row["fecha"];
}

# Verificamos si el boton del formulario fue precionado
if (!empty($_POST["enviar_ingreso"])) {
    # Verificamos si alguno de los campos se encuentra vacio
    if (empty($_POST["tipo_ingreso"]) or empty($_POST["tasa_bcv"]) or empty($_POST["monto_dolares"]) or empty($_POST["monto_bolivares"]) or empty($_POST["fecha"])){
        echo "Los campos estan vacios";
    }else{
        # Almacenamos los nuevos datos del registro en las variables
        $tipo_ingreso = $_POST["tipo_ingreso"];
        $tasa_bcv = $_POST["tasa_bcv"];
        $monto_dolares = $_POST["monto_dolares"];
        $monto_bolivares = $_POST["monto_bolivares"];
        $fecha = date("Y/m/d",strtotime($_POST["fecha"])) ;

        # Realizamos la consulta para actalizar el registro de la base de datos
        $sql = $connect->query("UPDATE ingresos SET tipo_ingreso='$tipo_ingreso' ,tasa_bcv=$tasa_bcv ,monto_dolares=$monto_dolares ,monto_bolivares=$monto_bolivares ,fecha='$fecha'  WHERE id_ingreso = $id");
        echo "<script> alert('¡Modificado con exito!'); window.location.href='../mostrar_datos_ingresos.php'; </script>";
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

<body>
    <header>
        <div class="cabecera">
            <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
        </div>
    </header>
    
    <!-- Formulario para editar el registro de los gastos -->
    <div class="contenedor">
        <form method="POST">
            <p>MODIFICAR REGISTRO INGRESOS</p>
            <p>Tipo de Ingreso</p>
            <select name="tipo_ingreso" required>
                <option value="Punto de venta" <?= ($tipo_ingreso == "Punto de venta") ? "selected" : "" ?> >Punto de venta</option>
                <option value="Transferencia" <?= ($tipo_ingreso == "Transferencia") ? "selected" : "" ?> >Transferencia</option>
                <option value="Divisa" <?= ($tipo_ingreso == "Divisa") ? "selected" : "" ?> >Divisa</option>
                <option value="Efectivo" <?= ($tipo_ingreso == "Efectivo") ? "selected" : "" ?> >Efectivo</option>
                <option value="Pago movil" <?= ($tipo_ingreso == "Pago movil") ? "selected" : "" ?> >Pago movil</option>
                <option value="Biopago" <?= ($tipo_ingreso == "Biopago") ? "selected" : "" ?> >Biopago</option>
            </select>
            <p>Tasa BCV</p>
            <input type="number" name="tasa_bcv" step="0.01" value="<?=$tasa_bcv?>" class="tasa_bcv" required>
            <p>Monto en Dolares</p>
            <input type="number" name="monto_dolares" step="0.01" value="<?=$monto_dolares?>" class="monto_dolares" required>
            <p>Monto en Bolivares</p>
            <input type="number" name="monto_bolivares" step="0.01" value="<?=$monto_bolivares?>" class="monto_bolivares" readonly required>
            <p>Fecha</p>
            <input type="date" name="fecha" value="<?=$fecha?>" required>
            <div class="botones_accion">
                <input class="btn"  id="btn_enviar_datos_1" name="enviar_ingreso" type="submit" value="Modificar">
                <a class="btn cerrar" href="../index.php">Cancelar</a>
            </div>
        </form>
    </div>

    <footer>
		<h3>Sistema para el Control Financiero</h3>
		<b>© Copyright  2024</b>
    </footer>

    <script src="../js/script.js"></script> 
</body>
</html>