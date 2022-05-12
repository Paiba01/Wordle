<?php
    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try {     
        session_start();     
        //Obtenemos los datos insertados
        $titulo = $_POST["campo_titulo"];
        $comentario = $_POST["area_comentarios"];
        $username7 = $_SESSION["username"];
        $fecha = date("Y-m-d H:i:s");
        $identificador7 = $_SESSION["id"];

        if ($titulo == "" || $comentario == "" || $username7 == "" || $fecha == "") {
            http_response_code(400);
            echo "Bad Request";
            return;
        }

        /*Comprobar conexión */
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*Ejecutar consulta en la bd*/
        $sql = "INSERT INTO comentarios (titulo, comentario, username, fecha, userId) VALUES ('$titulo', '$comentario', '$username7', '$fecha', '$identificador7')";
        $result2 = $conn->exec($sql);

            if (!$result2) { //Si algo ha fallado
                http_response_code(500);
                echo ' 
                    <script>
                        alert("No se ha podido registrar el comentario, inténtelo de nuevo");
                        window.location = "../html/formulario.html";
                    </script>
                ';
            }
            else { //Si todo ha salido correctamente
                http_response_code(200);
                echo ' 
                    <script>
                        alert("Comentario registrado satisfactoriamente");
                        window.location = "../html/formulario.html";
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

<a href="formulario.html">Añadir nueva entrada</a>
<a href="mostrar_blog.php">Ver blog</a>
