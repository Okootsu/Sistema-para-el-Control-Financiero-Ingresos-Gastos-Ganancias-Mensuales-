<?php
include ("../php/conexion_db.php");

if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $connect->query("DELETE FROM usuarios WHERE cedula = $id");
    if ($sql==1) {
        header("location:../php/admin_usuarios.php");
    }else{
        echo "Ocurrio un error";
    }
}

?>