<?php
    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try {  
        //Gets the insertion data
        $username1 = $_REQUEST["username"];
        $password1 = $_REQUEST["password"];
        $nombre = $_REQUEST["nombre"];
        $apellidos = $_REQUEST["apellidos"];
        $email = $_REQUEST["email"];

        if ($username1 == "" || $password1 == "" || $nombre == "" || $apellidos == "" || $email == "") {
            http_response_code(400);
            echo "Bad Request";
            return;
        }

        //tries to connect to the databse
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Executes an insert sql query
        $table = "usuarios";
        $sql = "INSERT INTO usuarios (username, password, nombre, apellidos, email) VALUES ('$username1', '$password1', '$nombre', '$apellidos', '$email')";
        $result = $conn->exec($sql);


        /*Verify users NO SE PORQUE NO VA
        $verificar_email = mysqli_query($conn, "SELECT * FROM usuarios WHERE email='$email' ");
        $verificar_username = mysqli_query($conn, "SELECT * FROM usuarios WHERE username='$username1' ");

        if(mysqli_num_rows($verificar_email) > 0){
            echo ' 
                <script>
                    alert("Este correo electrónico ya se encuentra registrado, inténtalo con otro diferente");
                    window.location = "../../index.html";
                </script>
            ';
            exit();            
        }

        if(mysql_num_rows($verificar_username)>0){
            echo ' 
                <script>
                    alert("Este nombre de usuario ya se encuentra registrado, inténtalo con otro diferente");
                    window.location = "../../index.html";
                </script>
            ';
            exit();            
        }
        */

        if (!$result) {
            http_response_code(500);
            echo ' 
                <script>
                    alert("No se ha podido completar el registro, inténtelo de nuevo");
                    window.location = "../../index.html";
                </script>
            ';
            //print "ERROR: " . $conn->errorMsg() . "\r\n";
        }
        else {
            http_response_code(200);
            echo ' 
                <script>
                    alert("Usuario registrado satisfactoriamente");
                    window.location = "../../index.html";
                </script>
            ';
            //print $name . " was succesfully added to the database \r\n";
        }

    }
    catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            http_response_code(205);
            echo "usuarios already added";
        }
        else {
            http_response_code(500);
            echo "Connection failed: " . $e->getMessage();
        }
    }
?>