<?php
# Vinculamos la conexion a la base de datos
include ("conexion_db.php");

# Obtenemos el id del usuario del gasto por la url
$id = $_GET["id"];

# Realizamos la consulta a la base de datos
$sql = $connect->query("SELECT * FROM usuarios WHERE cedula = $id");

# Almacenamos los resultado en las variables
while ($row = $sql->fetch_array()) {
    $cedula = $row["cedula"];
    $nombre = $row["nombre"];
    $apellido = $row["apellido"];
    $contraseña = $row["contraseña"];
    $nivel_usuario = $row["nivel_autorizacion"];
}

# Verificamos si el boton del formulario fue precionado
if (!empty($_POST["registrar"])) {
    # Verificamos si alguno de los campos se encuentra vacio
    if(empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["cedula"]) or empty($_POST["contraseña"]) or empty($_POST["nivel_usuario"])){ 
        echo 'Uno de los campos se encuentra vacío'; 
    } else{ 
        # Almacenamos los nuevos datos del registro en las variables
        $nombre = $_POST["nombre"]; 
        $apellido = $_POST["apellido"]; 
        $cedula = $_POST["cedula"]; 
        $contraseña = $_POST["contraseña"]; 
        $nivel_usuario = $_POST["nivel_usuario"];

        # Realizamos la consulta para actalizar el registro de la base de datos
        $sql = $connect->query("UPDATE usuarios SET cedula=$cedula,nombre='$nombre',apellido='$apellido',contraseña='$contraseña',nivel_autorizacion='$nivel_usuario' WHERE cedula = $cedula"); 
        echo "<script> alert('Usuario Modificado con Exito!'); window.location.href='../admin_usuarios.php';</script>";
    } 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Usuario</title>
</head>

<body>
    <header>
        <div class="cabecera">
            <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
        </div>
    </header>

    <div class="login">
        <div class="login-inicio">
            <div class="login-screen">
                <form method="POST" autocomplete="off">
                    <div class="app-title">
                        <img src="../resource/Login.jpg" width="70" height="70">
                        <p style="text-align: left;">Editar Usuarios</p>
                    </div>
                    <div class="login-form">
                        <div class="control-group">
                            <p>Nombre</p>
                            <input type="text" class="login-field" name="nombre" placeholder="Nombre" id="nombre" value="<?=$nombre?>" required>
                        </div>
                        <div class="control-group">
                            <p>Apellido</p>
                            <input type="text" class="login-field" name="apellido" placeholder="Apellido" id="apellido" value="<?=$apellido?>" required>
                        </div>
                        <div class="control-group">
                            <p>Cedula</p>
                            <input type="number" class="login-field" name="cedula" placeholder="Cedula" id="login-name" value="<?=$cedula?>" required>
                        </div>
                        <div class="control-group">
                            <p>Contraseña</p>
                            <input type="password" class="login-field" name="contraseña" placeholder="Password" id="login-password" value="<?=$contraseña?>" required>
                        </div>
                        <div class="control-group">
                            <p>Nivel de usuario</p>
                            <select id="role" name="nivel_usuario" required>
                                <option value="admin" <?= ($nivel_usuario == "admin") ? "selected" : "" ?>>Admin</option>
                                <option value="usuario" <?= ($nivel_usuario == "usuario") ? "selected" : "" ?>>Usuario</option>
                            </select>
                        </div>
                        <div class="botones_accion">
                            <input class="btn btn_accion" type="submit" name="registrar" value="Editar">
                            <a class="btn cerrar btn_accion" href="admin_usuarios.php">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <footer>
		<h3>Sistema para el Control Financiero</h3>
		<b>© Copyright  2024</b>
	</div>

</body>
</html>


