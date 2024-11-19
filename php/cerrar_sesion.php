<?php
# Iniciamos la session
session_start();

# Eliminamos la variables de session
session_unset();

# Cerramos la sesion del usuario
session_destroy();

# Redirigimos a usuario a la pagina de Inicio de Sesion
header("location:../login.php")
?>