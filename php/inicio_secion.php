<?php
session_start();

if (!empty($_POST["login"])) {
    if (empty($_POST{"cedula"}) and empty($_POST["contraseña"])) {
        echo "LOS CAMPOS ESTAN VACIOS";
    }else{
        $cedula = $_POST["cedula"]; 
        $contraseña = $_POST["contraseña"];
        $sql = $connect->query("SELECT * FROM usuarios WHERE cedula = '$cedula' and contraseña='$contraseña'");
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