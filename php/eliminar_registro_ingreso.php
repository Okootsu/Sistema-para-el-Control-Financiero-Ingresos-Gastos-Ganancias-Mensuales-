<?php
include ("../php/conexion_db.php");

if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $connect->query("DELETE FROM ingresos WHERE id_ingreso = $id");
    if ($sql==1) {
        header("location:mostrar_datos_ingresos.php");
    }else{
        echo "Ocurrio un error";
    }
}

?>