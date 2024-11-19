<?php
# Iniciamos una sesión
session_start();

# Verificamos si el usuario inició sesión, si no lo regresamos a la página de "login"
if (empty($_SESSION["cedula"])) {
    header("location:login.php");
}

# Array para convertir el número del mes a su nombre
$nombresMeses = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganancias del Mes</title>

    <!-- Link para vincular el css -->
    <link rel="stylesheet" href="css/style.css">
    
</head>

<body>
    <header>
        <div class="cabecera">
            <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
            <div class="iniciar_registrar">
                <a href="php/cerrar_sesion.php">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <!-- Mensaje de bienvenida para el usuario -->
    <div class="contenedor" id="bienvenida">
        <center><img src="resource/Login.jpg" width="70"></center>
        <?php
        echo "¡Hola ".$_SESSION["nombre"]." ".$_SESSION["apellido"]."!"
        ?>
        <p id="mensaje_bienvenida">Bienvenido al Sistema de Gestión de Ingresos y Gastos</p>
    </div>

    <!-- Contenedor con las opciones para el menú del usuario -->
    <div class="contenedor contenedor_opciones">
        <?php
        # Verificamos si el usuario que inició sesión es "administrador"
        if ($_SESSION["nivel_autorizacion"] == "admin") {
            echo "<a class='btn btn_accion' href='admin_usuarios.php'>Gestionar Usuarios</a>";
        }
        ?>
        <a class="btn btn_accion" href="index.php">Inicio</a>
        <button class="btn btn_accion" onclick="abrir_opciones()">Nuevo</button>
        <a class="btn btn_accion" href="mostrar_datos_ingresos.php">Ingresos</a>
        <a class="btn btn_accion" href="mostrar_datos_gastos.php">Gastos</a>
        <a class="btn btn_accion" href="ganancias.php">Generar reporte</a>
    </div>
    
    <!-- Formulario de Selección de Mes y Año -->
    <div class="contenedor contenedor-ganacias">
        <form method="POST" action="" class="form-ganancias">
            <label for="mes">Selecciona el Mes:</label>
            <select name="mes" id="mes" required>
                <option value="">--Seleccionar--</option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>

            <label for="año">Selecciona el Año:</label>
            <select name="año" id="año" required>
                <?php
                $currentYear = date("Y");
                for ($i = $currentYear; $i >= 2000; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <input type="submit" value="Consultar">
        </form>
    </div>

    <!-- Contenedor para mostrar la información de la tabla de ganancias -->
    <div class="contenedor mostrar_informacion">
        <?php
        # Vinculamos la conexión a la base de datos
        include ("php/conexion_db.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mesSeleccionado = $_POST['mes'];
            $añoSeleccionado = $_POST['año'];

            # Sentencia SQL para seleccionar los montos de ingresos y gastos del mes seleccionado
            $sql_ingresos = $connect->query("
                SELECT monto_bolivares 
                FROM ingresos 
                WHERE MONTH(fecha) = $mesSeleccionado AND YEAR(fecha) = $añoSeleccionado
            ");

            $sql_gastos = $connect->query("
                SELECT monto_bolivares 
                FROM gastos 
                WHERE MONTH(fecha) = $mesSeleccionado AND YEAR(fecha) = $añoSeleccionado
            ");

            # Creamos dos listas para almacenar los resultados
            $ingresos = [];
            $gastos = [];

            # Verificamos si se encontraron resultados en las tablas
            if ($sql_gastos->num_rows > 0 || $sql_ingresos->num_rows > 0) {
                if ($sql_ingresos) {
                    # Almacenamos la información en la lista "ingresos"
                    while ($row = $sql_ingresos->fetch_assoc()) {
                        $ingresos[] = $row["monto_bolivares"];
                    }
                }
                if ($sql_gastos) {
                    # Almacenamos la información en la lista "gastos"
                    while ($row = $sql_gastos->fetch_assoc()) {
                        $gastos[] = $row["monto_bolivares"];
                    }
                }
                # Obtenemos el número máximo de los registros
                $max_registros = max(count($ingresos), count($gastos));
                ?>
                <h2>Ganancias del mes <?php echo "$nombresMeses[$mesSeleccionado]"; ?></h2>
                <div id='tabla_informacion'>
                <table id='tabla'>
                <tr>
                    <th>Ingresos</th>
                    <th>Gastos</th>
                    <th>Total de Ganancias</th>
                </tr>
                <?php

                # Mostramos los montos de los ingresos y gastos
                for ($i = 0; $i < $max_registros; $i++) { 
                    $monto_ingreso = isset($ingresos[$i]) ? $ingresos[$i]." Bs" : '---'; # Asignar "---" si no hay ingreso
                    $monto_gasto = isset($gastos[$i]) ? $gastos[$i]." Bs" : '---'; # Asignar "---" si no hay gasto
                    ?>
                    <tr>
                        <td><?=$monto_ingreso?></td>
                        <td><?="-".$monto_gasto?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                
                # Calculamos las ganancias totales con respecto a los gastos
                $ganancias = array_sum($ingresos) - array_sum($gastos);
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?=$ganancias." Bs"?></td>
                </tr>
                </table>
                </div>
                <?php
            } else {
                ?>
                <div class='alert-danger'>
                    <b>No hay resultados para el mes seleccionado</b>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Modal de las opciones para los ingresos y gastos -->
    <dialog id="modal_opciones">
        <div class="botones_accion">
            <button class="btn" id="btn_add_ingreso" onclick="abrir_ingresos()">Registrar Ingreso</button>
            <button class="btn" id="btn_add_gasto" onclick="abrir_gastos()">Registrar Gasto</button>
            <button class="btn" id="btn_cerrar_opcion" onclick="cerrar_opciones()">Cerrar</button>
        </div>
    </dialog>

    <!-- Formulario Registro de Ingresos -->
    <dialog class="contenedor" id="modal_ingresos">
        <form method="POST">
            <?php
            # Vinculamos la conexión y el registro de ingresos
            include("php/conexion_db.php");
            include("php/registrar_ingresos.php");
            ?>
            <p>Tipo de Ingreso</p>
            <select name="tipo_ingreso" required>
                <option value="Punto de venta">Punto de venta</option>
                <option value="Transferencia">Transferencia</option>
                <option value="Divisa">Divisa</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Pago movil">Pago movil</option>
                <option value="Biopago">Biopago</option>
            </select>
            <p>Tasa BCV</p>
            <input type="number" name="tasa_bcv" step="0.01" class="tasa_bcv" required>
            <p>Monto en Dólares</p>
            <input type="number" name="monto_dolares" step="0.01" class="monto_dolares" required>
            <p>Monto en Bolívares</p>
            <input type="number" name="monto_bolivares" step="0.01" class="monto_bolivares" readonly required>
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
            # Vinculamos la conexión y el registro de gastos
            include("php/conexion_db.php");
            include("php/registrar_gastos.php");
            ?>
            <p>Descripción</p>
            <input name="descripcion" type="text" placeholder="Ejemplo: Factura, SENIAT, etc." required>
            <p>Tipo de Pago</p>
            <select name="tipo_pago" required>
                <option value="Punto de venta">Punto de venta</option>
                <option value="Transferencia">Transferencia</option>
                <option value="Divisa">Divisa</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Pago movil">Pago movil</option>
                <option value="Biopago">Biopago</option>
            </select>
            <p>Tasa BCV</p>
            <input name="tasa_bcv" type="number" step="0.01" class="tasa_bcv" required>
            <p>Monto en Dólares</p>
            <input name="monto_dolares" type="number" step="0.01" class="monto_dolares" required>
            <p>Monto en Bolívares</p>
            <input name="monto_bolivares" type="number" step="0.01" class="monto_bolivares" readonly required>
            <p>Fecha</p>
            <input name="fecha" type="date" required>
            <div class="botones_accion">
                <input class="btn" name="enviar_gasto" id="btn_enviar_datos_2" type="submit" value="Enviar">
                <button class="btn" id="btn_cerrar_modal_gasto" onclick="cerrar_gastos()">Cerrar</button>
            </div>
        </form>
    </dialog>
    
    <footer>
        <h3>Sistema para el Control Financiero</h3>
        <b>© Copyright 2024</b>
    </footer>

</body>
</html>
