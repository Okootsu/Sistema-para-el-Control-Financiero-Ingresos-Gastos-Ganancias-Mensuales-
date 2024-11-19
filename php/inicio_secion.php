<?php
# Iniciamos una session
session_start();

# Verificamos si el boton del formulario del login fue precionado
if (!empty($_POST["login"])) {
    # Verificamos si algun campo se encuentra vacio
    if (empty($_POST{"cedula"}) and empty($_POST["contraseña"])){
        echo "LOS CAMPOS ESTAN VACIOS";
    }else{
        # Recibimos los datos del formulario
        $cedula = $_POST["cedula"]; 
        $contraseña = $_POST["contraseña"];

        # Sentencia SQL para consultar al usuario en la base de datos
        $sql = $connect->query("SELECT * FROM usuarios WHERE cedula = '$cedula' and contraseña='$contraseña'");
        
        # Si los datos son correcto almacenamos la informacion del usuario y le brindamos acceso a la pagina
        if ($datos=$sql->fetch_object()) {
            $_SESSION["nombre"] = $datos->nombre;
            $_SESSION["apellido"] = $datos->apellido;
            $_SESSION["cedula"] = $datos->cedula;
            $_SESSION["nivel_autorizacion"] = $datos->nivel_autorizacion;

            header("location:index.php");
        }else{
            echo "ACCESO DENEGADO";
        }
    }
}
?>