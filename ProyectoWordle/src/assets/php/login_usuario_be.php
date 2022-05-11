<?php
    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try {          
        //Obtenemos los datos insertados
        $username2 = $_POST["username"];
        $password2 = $_POST["password"];
        
        if ($username2 == "" || $password2 == "") {
            http_response_code(400);
            echo "Bad Request";
            return;
        }

        //Intento de conexión a la base de datos
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Ejecutar un select sql query
        $result = $conn->prepare("SELECT * FROM usuarios WHERE username='$username2' AND password='$password2'");
        $result->bindParam("username",$username2,PDO::PARAM_STR);
        $result->bindParam("password",$password2,PDO::PARAM_STR);
        $result->execute();
        $count = $result->rowCount();

        //Comprobamos si ha recogido valores en la variable count,
        //si recoge valores significa que está en la bd y
        //si no recoge ningún valor es que no
        //solo existirá habrá un 1 en count debido a que existe una restricción en el registro de usuarios dobles
        if($count){
            http_response_code(200);  
            $result2 = $conn->prepare("SELECT * FROM usuarios WHERE username='$username2' AND password='$password2'");
            $result2->bindParam("username",$username2,PDO::PARAM_STR);
            $result2->bindParam("password",$password2,PDO::PARAM_STR);
            $result2->execute();

            $userID = $result2->fetchColumn(0);
            $_SESSION["id"] = "$userID"; //Añadimos el identificador que tenga el usuario a la sesión         
            $_SESSION["username"]=$username2; //Añadimos el nombre de usuario a la sesión 
            
            echo ' 
                <script>
                    alert("Sesión iniciada correctamente");
                    window.location = "../../wordle.html";
                </script>
            ';
        }else{
            http_response_code(500);
            echo ' 
                <script>
                    alert("Los datos no coinciden, inténtelo de nuevo");
                    window.location = "../../index.html";
                </script>
            ';  
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