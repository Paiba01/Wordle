<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="shortcut icon" type="image/png" href="../../favicon.png"/>
    <title>Blog</title>
</head>
<body>
<header class="header">
        <div id="encabezado">
            <div id="logo">
                BLOG WORDLE
            </div>

            <div id="menu">
                <ul>
                    <li><a href="../html/formulario.html" class="active-menu">Añadir comentario</a></li>
                    <li><a href="../../wordle.html" class="active-menu">Volver atrás</a></li>
                </ul>
            </div>
        </div>
    </header>
<?php

    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try{

        /*Comprobar conexión */
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*Ejecutar consulta en la bd*/
        $result2 = $conn->prepare("SELECT * FROM comentarios ORDER BY fecha DESC");
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
            http_response_code(200);
        
            while($registro = $result2->fetch(PDO::FETCH_ASSOC)){
                echo "<section id='principal'>";
                echo "<section id='publicaciones'>";
                echo "<article class='post'>";
                echo "<h3>" . $registro['titulo'] . "</h3>";
                echo "<p>";
                echo "<h4>" . $registro['fecha'] . "</h4>";
                echo "<p class='parrafo-post'>" . $registro['comentario'] . "</p>";
                echo "<div style='width:400px'>" . "<h4>Realizado por: " . $registro['username'] . "</h4>" . "</div><br/><br/>";
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
</body>
</html>