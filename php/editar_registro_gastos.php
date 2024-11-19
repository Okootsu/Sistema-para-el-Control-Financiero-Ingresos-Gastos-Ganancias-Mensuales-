<?php
# Vinculamos la conexion a la base de datos
include ("conexion_db.php");

# Obtenemos el id del registro del gasto por la url
$id = $_GET["id"];

# Realizamos la consulta a la base de datos
$sql = $connect->query("SELECT * FROM gastos WHERE id_gasto = $id");

# Almacenamos los resultado en las variables
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

# Verificamos si el boton del formulario fue precionado
if (!empty($_POST["enviar_gasto"])){
    # Verificamos si alguno de los campos se encuentra vacio
    if (empty($_POST["descripcion"]) or empty($_POST["tipo_pago"]) or empty($_POST["tasa_bcv"]) or empty($_POST["monto_dolares"]) or empty($_POST["monto_bolivares"]) or empty($_POST["fecha"])){
        echo "Los campos estan vacios";
    }else{
        # Almacenamos los nuevos datos del registro en las variables
        $descripcion = $_POST["descripcion"];
        $tipo_pago = $_POST["tipo_pago"];
        $tasa_bcv = $_POST["tasa_bcv"];
        $monto_dolares = $_POST["monto_dolares"];
        $monto_bolivares = $_POST["monto_bolivares"];
        $fecha =date("Y/m/d",strtotime($_POST["fecha"]));

        # Realizamos la consulta para actalizar el registro de la base de datos
        $sql = $connect->query("UPDATE gastos SET descripcion='$descripcion',tipo_pago='$tipo_pago',tasa_bcv=$tasa_bcv,monto_dolares=$monto_dolares,monto_bolivares=$monto_bolivares,fecha='$fecha' WHERE id_gasto = $id");
        echo "<script> alert('¡Modificado con exito!'); window.location.href='../mostrar_datos_gastos.php'; </script>";
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

<body>
    <header>
        <div class="cabecera">
            <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
        </div>
    </header>
    
    <!-- Formulario para editar el registro de los gastos -->
    <div class="contenedor">
        <form method="POST">
            <p>MODIFICAR REGISTRO GASTO</p>
            <p>Descripcion</p>
            <input name="descripcion" type="text" placeholder="Ejemplo: Factura,SENIAT, etc" value="<?=$descripcion?>" required>
            <p>Tipo de Pago</p>
            <select name="tipo_pago" required>
                <option value="Punto de venta" <?= ($tipo_pago == "Punto de venta") ? "selected" : "" ?> >Punto de venta</option>
                <option value="Transferencia" <?= ($tipo_pago == "Transferencia") ? "selected" : "" ?> >Transferencia</option>
                <option value="Divisa" <?= ($tipo_pago == "Divisa") ? "selected" : "" ?> >Divisa</option>
                <option value="Efectivo" <?= ($tipo_pago == "Efectivo") ? "selected" : "" ?> >Efectivo</option>
                <option value="Pago movil" <?= ($tipo_pago == "Pago movil") ? "selected" : "" ?> >Pago movil</option>
                <option value="Biopago" <?= ($tipo_pago == "Biopago") ? "selected" : "" ?> >Biopago</option>
            </select>
            <p>Tasa BCV</p>
            <input name="tasa_bcv" type="number" step="0.01" value="<?=$tasa_bcv?>" class="tasa_bcv" required>
            <p>Monto en Dolares</p>
            <input name="monto_dolares" type="number" step="0.01" value="<?=$monto_dolares?>" class="monto_dolares" required>
            <p>Monto en Bolivares</p>
            <input name="monto_bolivares" type="number" step="0.01" value="<?=$monto_bolivares?>" class="monto_bolivares" readonly required>
            <p>Fecha</p>
            <input name="fecha" type="date" value="<?=$fecha?>" required>
            <div class="botones_accion">
                <input class="btn" name="enviar_gasto" id="btn_enviar_datos_2" type="submit" value="Enviar">
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