<?php
$resultado_x_pagina = 5; // Numero de resultados a mostrar

$sql = $connect->query("SELECT COUNT(*) AS total FROM ingresos"); //Consulta a la base de datos para saber la cantidad de registros
$row = $sql->fetch_array();
$registros_totales = $row["total"]; // Obtenemos el numero de registros totales

$paginas_totales = ceil($registros_totales / $resultado_x_pagina); // Calcular cuantas paginas necesitamos


$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Obtener el valor de "pagina"

if ($pagina < 1) {
    $pagina = 1;
} elseif ($pagina > $paginas_totales) {
    $pagina = $paginas_totales;
}

$iniciar = ($pagina - 1) * $resultado_x_pagina;


// Realizar la consulta con el numero de resultados a mostrar
$sql = $connect->query("SELECT * FROM tu_tabla LIMIT $iniciar, $resultado_x_pagina"); // Consulta para obtener los resultados de la página actual.

if ($sql->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Tipo de ingreso</th>";
    echo "<th>Tasa BCV</th>";
    echo "<th>Monto en dolares</th>";
    echo "<th>Monto en bolivares</th>";
    echo "<th>Fecha</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";

    while ($row = $sql->fetch_array()) {
        $id = $row["id_ingreso"];
        $tipo_ingreso = $row["tipo_ingreso"];
        $tasa_bcv = $row["tasa_bcv"];
        $monto_dolares = $row["monto_dolares"];
        $monto_bolivares = $row["monto_bolivares"];
        $fecha = $row["fecha"];
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$tipo_ingreso </td>";
        echo "<td>$tasa_bcv</td>";
        echo "<td>$monto_dolares</td>";
        echo "<td>$monto_bolivares</td>";
        echo "<td>$fecha</td>";
        echo "<td class='action'> <a class='editar' id='editar' href='../php/editar_registro_ingresos.php?id=$id'>Editar</a> <a class='eliminar' id='eliminar' onclick='eliminar_ingreso($id)'>Eliminar</a> </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay resultados.";
}

echo '<div class="pagination">';
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> "; // Página actual
    } else {
        echo "<a href='tu_archivo.php?page=$i'>$i</a> ";
    }
}
echo '</div>';

?>