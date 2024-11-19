<?php
# Iniciamos una session
session_start();

# Verificamos si se inicio sesion y verificamos si el usuario es administrador si no es asi se redirique a la pagina de "login"
if (empty($_SESSION["cedula"]) || $_SESSION["nivel_autorizacion"] !== "admin") {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Usuarios</title>

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
        <p id="mensaje_bienvenida">Bienvenido al Sistema de Gestion de Ingresos y Gastos</p>
    </div>

    <!-- Contenedor con las opciones para el menu del usuario -->
    <div class="contenedor contenedor_opciones">
        <?php 
        # Verificamos si el usuario que inicio sesion es "administrador" si es asi, activamos la opcion para admistrar a los usuarios
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
    
    <!-- Contenedor para mostrar la tabla de los usuarios registrados -->
    <div class="contenedor mostrar_informacion">
        <?php
        # Incluimos la conexion a la base de datos
        include("php/conexion_db.php");
        
        # Hacemos la consulta a la base de datos
        $sql = $connect->query("SELECT * FROM usuarios");

        # Verificamos si existen datos lo mostramos al usuario y si no se le muestra un mensaje
        if($sql->num_rows >0){
            ?>
            <h2>Usuarios Registrados</h2>
            <div id='tabla_informacion'>
            <table id='tabla'>
            <tr>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Nivel de autorizacion</th>
            <th>Acciones</th>
            </tr>
            <?php
            while ($row = $sql->fetch_array()){
                $cedula = $row["cedula"];
                $nombre = $row["nombre"];
                $apellido = $row["apellido"];
                $nivel_usuario = $row["nivel_autorizacion"];
                ?>
                <tr>
                <td><?=$cedula?></td>
                <td><?=$nombre?></td>
                <td><?=$apellido?></td>
                <td><?=$nivel_usuario?></td>
                <td class='action'> <a class='editar' id='editar' href='php/editar_usuario.php?id=<?=$cedula?>'>Editar</a> <a class='eliminar' id='eliminar' onclick='eliminar_usuario(<?=$cedula?>)'>Eliminar</a> </td>
                </tr>
                <?php
            }
        ?>
        </table>
        </div>
        <?php
        }else {
            ?>
            <div class='alert-danger'>
            <b>No hay resultados</b
            </div>
            <?php
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
            # Vinculamos la conexion y el registro de ingresos
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
            <p>Monto en Dolares</p>
            <input type="number" name="monto_dolares" step="0.01" class="monto_dolares" required>
            <p>Monto en Bolivares</p>
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
            # Vinculamos la conexion y el registro de gastos
            include("php/conexion_db.php");
            include("php/registrar_gastos.php");
            ?>
            <p>Descripcion</p>
            <input name="descripcion" type="text" placeholder="Ejemplo: Factura,SENIAT, etc" required>
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
            <p>Monto en Dolares</p>
            <input name="monto_dolares" type="number" step="0.01" class="monto_dolares" required>
            <p>Monto en Bolivares</p>
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
		<b>© Copyright  2024</b>
    </footer>

    <script src="js/script.js"></script>   
</body>
</html>