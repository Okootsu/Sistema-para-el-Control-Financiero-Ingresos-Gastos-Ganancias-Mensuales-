<?php
include ("conexion_db.php");
$id = $_GET["id"];

$sql = $connect->query("SELECT * FROM usuarios WHERE cedula = $id");

$cedula;
$nombre;
$apellido;
$nivel_usuario;
$contraseña;

while ($row = $sql->fetch_array()) {
    $cedula = $row["cedula"];
    $nombre = $row["nombre"];
    $apellido = $row["apellido"];
    $contraseña = $row["contraseña"];
    $nivel_usuario = $row["nivel_autorizacion"];
}

if (!empty($_POST["registrar"])) {
    if(empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["cedula"]) or empty($_POST["contraseña"]) or empty($_POST["nivel_usuario"])){ 
        echo 'Uno de los campos se encuentra vacío'; 
    } else{ 
        $nombre = $_POST["nombre"]; 
        $apellido = $_POST["apellido"]; 
        $cedula = $_POST["cedula"]; 
        $contraseña = $_POST["contraseña"]; 
        $nivel_usuario = $_POST["nivel_usuario"];
        $sql = $connect->query("UPDATE usuarios SET cedula=$cedula,nombre='$nombre',apellido='$apellido',contraseña=$contraseña,nivel_autorizacion='$nivel_usuario' WHERE cedula = $cedula"); 
        echo "<script> alert('Usuario Modificado con Exito!'); window.location.href='admin_usuarios.php';</script>";
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

<header>
    <div class="cabecera">
        <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
    </div>
</header>

<body>
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
</body>

<footer>
	<div class="footer_main">
		<h3>Sistema para el Control Financiero</h3>
		<b>© Copyright  2024</b>
	</div>
</footer>

</html>


