<?php

    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try{
        session_start();
        $idOrg = $_SESSION["id"];
        /*Comprobar conexión */
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*Ejecutar consulta en la bd*/
        $result2 = $conn->prepare("SELECT * FROM amigos WHERE idUser='$idOrg'");
        $result2->execute();

        if (!$result2) { //Si algo ha fallado
            http_response_code(500);
            echo ' 
                <script>
                    alert("No se han podido cargar los comentarios, inténtelo de nuevo");
                    window.location = "../../index.html";
                </script>
            ';
        }
        else { //Si todo ha salido correctamente
        echo "<header class='header'>";
        echo "<div id='encabezado'>";
        echo "<div id='logo'>" . "AMIGOS" . "</div>";
        echo "<div id='menu'>";
        echo "<ul>";
        echo "<li>";
        echo "<ul><li><a href='../html/agregarAmigo.html' class='active-menu2'>";
        echo "Añadir amigo." . " Tu ID es: " . $idOrg;
        echo "</a>";
        echo "</li>";
        echo "<li><a style='left: 300px;' href='../html/indexAmigos.html' class='active-menu'> Volver atrás</a></li>";
        echo "</ul>";
        echo "</div>";
        echo "</div>";
        echo "</header>";
            http_response_code(200);
            while($lista = $result2->fetch(PDO::FETCH_ASSOC)){
                echo "<section id='principal'>";
                echo "<section id='publicaciones'>";
                echo "<article class='post'>";
                echo "<h3>Nombre: " . $lista['nombre'] . "</h3>";
                echo "<p>";
                echo "<h3>Apellidos: " . $lista['apellidos'] . "</h3>";
                echo "<h3>Username: " . $lista['username'] . "</h3>";
                
                echo "</article>";
                echo "</section>";
                echo "</section id='sidebar'></section>";
                echo "</section>";
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
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="shortcut icon" type="image/png" href="../../favicon.png"/>
    <title>Amigos</title>
</head>
<body>

</body>
</html>
