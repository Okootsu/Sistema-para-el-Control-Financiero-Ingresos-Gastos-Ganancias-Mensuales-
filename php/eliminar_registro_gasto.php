<?php
# Vinculamos la conexion a la base de datos
include ("../php/conexion_db.php");

# Verificamos si se compartio el id del registro por la url
if (!empty($_GET["id"])) {
    $id = $_GET["id"];

    # Consulta SQL para borrar el registro
    $sql = $connect->query("DELETE FROM gastos WHERE id_gasto = $id");
    if ($sql==1) {
        echo "<script> alert('¡Eliminado con exito!'); window.location.href='mostrar_datos_gastos.php'; </script>";
    }else{
        echo "Ocurrio un error";
    }
}

?>