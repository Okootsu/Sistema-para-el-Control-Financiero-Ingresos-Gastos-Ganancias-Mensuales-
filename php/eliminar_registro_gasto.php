<?php
include ("../php/conexion_db.php");

if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $connect->query("DELETE FROM gastos WHERE id_gasto = $id");
    if ($sql==1) {
        header("location:mostrar_datos_gastos.php");
    }else{
        echo "Ocurrio un error";
    }
}

?>