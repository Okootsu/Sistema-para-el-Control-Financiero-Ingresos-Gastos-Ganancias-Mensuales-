<?php
session_start();
if (empty($_SESSION["cedula"])) {
    header("location:../login.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganancias del Mes</title>
    <link rel="stylesheet" href="../css/style.css">
    
</head>

<header>
    <div class="cabecera">
        <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
        <div class="iniciar_registrar">
            <a href="../php/cerrar_sesion.php">Cerrar Sesión</a>
        </div>
    </div>
</header>

<body>

    <div class="contenedor" id="bienvenida">
        <center><img src="../resource/Login.jpg" width="70"></center>
        <?php
        echo "¡Hola ".$_SESSION["nombre"]." ".$_SESSION["apellido"]."!"
        ?>
        <p id="mensaje_bienvenida">Bienvenido al Sistema de Gestion de Ingresos y Gastos</p>
    </div>

    <div class="contenedor contenedor_opciones">
        <?php 
        if ($_SESSION["nivel_autorizacion"] == "admin") {
            echo "<a class='btn btn_accion' href='php/admin_usuarios.php'>Gestionar Usuarios</a>";
        }
        ?>
        <a class="btn btn_accion" href="../index.php">Inicio</a>
        <a class="btn btn_accion" href="mostrar_datos_ingresos.php">Ingresos</a>
        <a class="btn btn_accion" href="mostrar_datos_gastos.php">Gastos</a>
        <button class="btn btn_accion" onclick="abrir_opciones()">Nuevo</button>
        <a class="btn btn_accion" href="ganancias.php">Generar reporte</a>
    </div>

    <div class="contenedor mostrar_informacion">
        <?php
        include ("../php/conexion_db.php");
        $sql_ingresos = $connect->query("SELECT monto_bolivares FROM ingresos");
        $sql_gastos = $connect->query("SELECT monto_bolivares FROM gastos");
        $ingresos = [];
        $gastos = [];
        if ($sql_gastos->num_rows and $sql_ingresos->num_rows >0) {
            if ($sql_ingresos) {
                while ($row = $sql_ingresos->fetch_assoc()) {
                    $ingresos[] = $row["monto_bolivares"];
                }
            }
            if ($sql_gastos) {
                while ($row = $sql_gastos->fetch_assoc()) {
                    $gastos[] = $row["monto_bolivares"];
                }
            }
            // Obtenemos el numero maximo de los registros
            $max_registros = max(count($ingresos),count($gastos));
            
            echo "<h2>Ganancias del mes</h2>";
            echo "<div id='tabla_informacion'>";
            echo "<table id='tabla'>";
            echo "<tr>";
            echo "<th>Ingresos</th>";
            echo "<th>Gastos</th>";
            echo "<th>Total de Ganancias</th>";
            echo "</tr>";
            for ($i=0; $i < $max_registros; $i++) { 
                $monto_ingreso = isset($ingresos[$i]) ? $ingresos[$i]." Bs" : '---'; // Asignar --- si no hay ingreso
                $monto_gasto = isset($gastos[$i]) ? $gastos[$i]." Bs" : '---'; // Asignar --- si no hay gasto
                echo "<tr>";
                echo "<td>$monto_ingreso </td>";
                echo "<td>-$monto_gasto </td>";
                echo "<td></td>";
                echo "</tr>";
            }
            $ganancias = array_sum($ingresos) - array_sum($gastos);
            echo "<tr>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td>$ganancias Bs</td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
        }else {
            echo "<div. class='alert-danger'>";
            echo "<b>No hay resultados</b>";
            echo "</div>.";
        }
        ?>
    </div>


    <!-- Modal de las opciones para los ingresos y gastos -->
    <dialog id="modal_opciones">
        <div class="botones_accion">
            <button class="btn" id="btn_add_ingreso" onclick="abrir_ingresos()">Registrar Ingreso</button>
            <button class="btn" id="btn_add_gasto" onclick="abrir_gastos()">Registrar Gasto</button>
            <button class="btn" id="btn_cerrar_opcion" onclick="cerrar_opciones()" >Cerrar</button>
        </div>
    </dialog>

    <!-- Formulario Registro de Ingresos -->
    <dialog class="contenedor" id="modal_ingresos">
        <form method="POST">
            <?php
            include("../php/conexion_db.php");
            include("../php/registrar_ingresos.php");
            ?>
            <p>Tipo de Ingreso</p>
            <input type="text" name="tipo_ingreso" placeholder="Ejemplo: Pto de Venta,etc" required>
            <p>Tasa BCV</p>
            <input type="number" name="tasa_bcv" step="0.01" required>
            <p>Monto en Dolares</p>
            <input type="number" name="monto_dolares" step="0.01" required>
            <p>Monto en Bolivares</p>
            <input type="number" name="monto_bolivares" step="0.01" required>
            <p>Fecha</p>
            <input type="date" name="fecha" required>
            <div class="botones_accion">
                <input class="btn" id="btn_enviar_datos_1" name="enviar_ingreso" type="submit" value="Enviar">
                <button class="btn" id="btn_cerrar_modal_ingreso" onclick="cerrar_ingresos()">Cerrar</button>
            </div>
        </form>
    </dialog>

    <!-- Formulario Registro de Gastos -->
    <dialog class="contenedor" id="modal_gastos">
        <form method="POST">
            <?php
            include("../php/conexion_db.php");
            include("../php/registrar_gastos.php");
            ?>
            <p>Descripcion</p>
            <input name="descripcion" type="text" placeholder="Ejemplo: Factura,SENIAT, etc" required>
            <p>Tipo de Pago</p>
            <input name="tipo_pago" type="text" placeholder="Ejemplo: Transferencia, Divisa, etc" required>
            <p>Tasa BCV</p>
            <input name="tasa_bcv" type="number" step="0.01" required>
            <p>Monto en Dolares</p>
            <input name="monto_dolares" type="number" step="0.01" required>
            <p>Monto en Bolivares</p>
            <input name="monto_bolivares" type="number" step="0.01" required>
            <p>Fecha</p>
            <input name="fecha" type="date" required>
            <div class="botones_accion">
                <input class="btn" name="enviar_gasto" id="btn_enviar_datos_2" type="submit" value="Enviar">
                <button class="btn" id="btn_cerrar_modal_gasto" onclick="cerrar_gastos()">Cerrar</button>
            </div>
        </form>
    </dialog>

    <script src="../js/script.js"></script> 
</body>

<footer>
	<div class="footer_main">
		<h3>Sistema para el Control Financiero</h3>
		<b>© Copyright  2024</b>
	</div>
</footer>

</html>