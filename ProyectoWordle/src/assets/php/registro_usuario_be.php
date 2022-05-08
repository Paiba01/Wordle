<?php

    include 'conexion_be.php'

    $username = $_POST['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];

    $query = "INSERT INTO usuarios(username, password, nombre, apellidos, email) 
              VALUES('$username', '$password', '$nombre', '$apellidos', '$email')";

    $ejecutar = mysqli_query($conexion, $query);

?>