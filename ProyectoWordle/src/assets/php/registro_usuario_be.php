<?php
    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try {  
        //Obtenemos los datos insertados
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

        //Intentamos conectarnos a la base de datos
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Comprobamos si existe el numero de usuario introducido mediante el número de filas que devuelve
        $result = $conn->prepare("SELECT * FROM usuarios WHERE username='$username1'");
        $result->bindParam("username",$username1,PDO::PARAM_STR);
        $result->execute();
        $count = $result->rowCount();
        if($count){ //Si existe ya una fila con ese nombre de usuario, prohibe el registro
            echo ' 
                <script>
                    alert("Este nombre de usuario ya se encuentra registrado, inténtalo con otro diferente");
                    window.location = "../../index.html";
                </script>
            ';
            exit();             
        }else{ //Si no existe el nombre de usuario, realizamos la misma comprobación pero con el email
            $result1 = $conn->prepare("SELECT * FROM usuarios WHERE email='$email'");
            $result1->bindParam("email",$email,PDO::PARAM_STR);
            $result1->execute();
            $count = $result1->rowCount(); 
            if($count){ //Si hay un email igual ya registrado
                echo ' 
                    <script>
                        alert("Este correo electrónico ya se encuentra registrado, inténtalo con otro diferente");
                        window.location = "../../index.html";
                    </script>
                ';
                exit();             
            }else{
                //Si no hay ni un nombre de usuario ni un email igual, entonces ejecutamos un insert sql query para realizar el registro
                $sql = "INSERT INTO usuarios (username, password, nombre, apellidos, email) VALUES ('$username1', '$password1', '$nombre', '$apellidos', '$email')";
                $result2 = $conn->exec($sql);

                if (!$result2) { //Si algo ha fallado
                    http_response_code(500);
                    echo ' 
                        <script>
                            alert("No se ha podido completar el registro, inténtelo de nuevo");
                            window.location = "../../index.html";
                        </script>
                    ';
                }
                else { //Si todo ha salido correctamente
                    http_response_code(200);
                    echo ' 
                        <script>
                            alert("Usuario registrado satisfactoriamente");
                            window.location = "../../index.html";
                        </script>
                    ';
                }

            }
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