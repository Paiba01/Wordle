<?php

    include 'conexion_be.php'

    $username1 = $_REQUEST["username"];
    $password1 = $_REQUEST["password"];

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE username='$username'
    and password='$password1'"); 

    if(mysqli_num_rows($validar_login) > 0){
        header("location: ../../wordle.html"); //redireccionar a esta página
        exit;
    }else{
        echo ' 
        <script>
            alert("El usuario no se encuentra registrado, verifique los datos introducidos");
            window.location = "../../index.html";
        </script>
        ';
        exit;
    }


?>