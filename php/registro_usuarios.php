<?php 
session_start();

if(!empty($_POST["registrar"])){
    // Verificar si el formulario fue enviado recientemente
    if (isset($_SESSION['ultimo_envio']) && time() - $_SESSION['ultimo_envio'] < 5) {
        header("Location:register.php"); // Redirigir a la misma página
        echo "Usuario Registrado";
    }

    // Actualizar el tiempo del último envío
    $_SESSION['ultimo_envio'] = time();

    if(empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["cedula"]) or empty($_POST["contraseña"])){ 
        echo 'Uno de los campos se encuentra vacío'; 
    } else{ 
        $nombre = $_POST["nombre"]; 
        $apellido = $_POST["apellido"]; 
        $cedula = $_POST["cedula"]; 
        $contraseña = $_POST["contraseña"]; 
        // Verificar si la cédula ya existe en la base de datos 
        $sql = $connect->query("SELECT * FROM usuarios WHERE cedula = '$cedula'"); 
        if($sql->num_rows > 0){ 
            echo "El usuario con la cédula $cedula ya se encuentra registrado."; 
        } else{ 
            $sql = $connect->query("INSERT INTO usuarios(cedula,nombre,apellido,contraseña) VALUES('$cedula','$nombre','$apellido','$contraseña')"); 
            echo "Usuario registrado con éxito!"; 
        } 
    }   
}
?>