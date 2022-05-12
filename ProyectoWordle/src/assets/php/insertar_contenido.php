<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>sin titulo</title>
</head>
<body>
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
            $username = $_POST["campo_username"];
            $fecha = date("d-m-Y H:i:s");
            $identificador = $_SESSION["id"];

            if ($titulo == "" || $comentario == "" || $username == "" || $fecha == "") {
                http_response_code(400);
                echo "Bad Request";
                return;
            }

            /*Comprobar conexión */
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /*Ejecutar consulta en la bd*/
            $sql = "INSERT INTO comentarios (titulo, comentario, username, fecha, userId) VALUES ('$titulo', '$comentario', '$username', '$fecha', '$identificador')";
            $result2 = $conn->exec($sql);

                if (!$result2) { //Si algo ha fallado
                    http_response_code(500);
                    echo ' 
                        <script>
                            alert("No se ha podido registrar el comentario, inténtelo de nuevo");
                            window.location = "../../index.html";
                        </script>
                    ';
                }
                else { //Si todo ha salido correctamente
                    http_response_code(200);
                    echo ' 
                        <script>
                            alert("Comentario registrado satisfactoriamente");
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

    <a href="formulario.php">Añadir nueva entrada</a>
    <a href="mostrar_blog.php">Ver blog</a>
</body>
