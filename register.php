<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <!-- Link para vincular el css -->
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
    <header>
        <div class="cabecera">
            <p><b>La Fortaleza C.A RIF: J-090345234</b></p>
            <div class="iniciar_registrar">
                <a href="login.php">Iniciar Sesion</a>
                <a href="register.php">Registrarse</a>
            </div>
        </div>
    </header>

    <!-- Formulario para el registro de los usuarios -->
    <div class="login">
        <div class="login-inicio">
            <div class="login-screen">
                <form method="POST" autocomplete="off">
                    <div class="app-title">
                        <img src="resource/Login.jpg" width="70" height="70">
                        <p style="text-align: left;">Registro de Usuarios</p>
                        <?php
                        # Vinculamos los archivos de conexion y registro de usuarios
                        include("php/conexion_db.php");
                        include("php/registro_usuarios.php");
                        ?>
                    </div>
                    <div class="login-form">
                        <div class="control-group">
                            <p>Nombre</p>
                            <input type="text" class="login-field" name="nombre" placeholder="Nombre" id="nombre">
                        </div>
    
                        <div class="control-group">
                            <p>Apellido</p>
                            <input type="text" class="login-field" name="apellido" placeholder="Apellido" id="apellido">
                        </div>
    
                        <div class="control-group">
                            <p>Cedula</p>
                            <input type="number" class="login-field" name="cedula" placeholder="Cedula" id="login-name">
                        </div>
       
                        <div class="control-group">
                            <p>Contraseña</p>
                            <input type="password" class="login-field" name="contraseña" placeholder="Password" id="login-password">
                        </div>
                        <input class="btn" type="submit" name="registrar" value="Registrarse">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer>
	    <h3>Sistema para el Control Financiero</h3>
	    <b>© 2024 Copyright</b>
    </footer>

</body>
</html>