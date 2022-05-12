<?php
    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try{
        session_start();
        $username2 = $_POST["nick"];
        $identificador2 = $_POST["ident"];
        $idOrg = $_SESSION["id"];

        /*Comprobar conexión */
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*Ejecutar consulta en la bd*/
        $result2 = $conn->prepare("SELECT * FROM usuarios WHERE userId='$identificador2' AND username='$username2'");
        $result2->execute();
        
        //necesitamos extraer la información del amigo al que agregar
        $registro = $result2->fetch(PDO::FETCH_ASSOC);
        $nombre2 = $registro['nombre'];
        $apellidos2 = $registro['apellidos'];

        if (empty($nombre2)) { //Si el nombre esta vacio es que no encuentra nada
            http_response_code(500);
            echo ' 
                <script>
                    alert("No se ha podido agregar amigo, inténtelo de nuevo");
                    window.location = "../../index.html";
                </script>
            ';
        }
        else { //Si todo ha salido correctamente
            http_response_code(200);

            $sql = "INSERT INTO amigos (nombre, apellidos, username, idUser) VALUES ('$nombre2', '$apellidos2', '$username2', '$idOrg')"; // insertar los amigos en una tabla de la bd
            $result2 = $conn->exec($sql);


            /*Ejecutar consulta en la bd*/
            $result3 = $conn->prepare("SELECT * FROM usuarios WHERE userId='$idOrg'");
            $result3->execute();
            
            //necesitamos extraer la información del amigo al que agregar
            $registro2 = $result3->fetch(PDO::FETCH_ASSOC);
            $nombre3 = $registro2['nombre'];
            $apellidos3 = $registro2['apellidos'];
            $username3 = $registro2['username'];

            $sql = "INSERT INTO amigos (nombre, apellidos, username, idUser) VALUES ('$nombre3', '$apellidos3', '$username3', '$identificador2')"; // insertar los amigos en una tabla de la bd
            $result3 = $conn->exec($sql);

            if (!$result2 || !$result3) { //Si algo ha fallado
                http_response_code(500);
                echo ' 
                    <script>
                        alert("No se ha podido registrar el comentario, inténtelo de nuevo");
                        window.location = "../html/indexAmigos.html";
                    </script>
                ';
            }
            else { //Si todo ha salido correctamente
                http_response_code(200);
                echo ' 
                    <script>
                        alert("Amigo agregado satisfactoriamente");
                        window.location = "../html/indexAmigos.html";
                    </script>
                ';
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