<?php
    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try {          
        //Obtenemos los datos insertados
        $contrasena3 = $_POST["contrasena1"];
        $contrasena4 = $_POST["contrasena2"];
        
        if ($contrasena3 == "" || $contrasena4 == "") {
            http_response_code(400);
            echo "Bad Request";
            return;
        }

        //Intento de conexión a la base de datos
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Ejecutar un select sql query
        $result = $conn->prepare("SELECT * FROM usuarios WHERE password='$contrasena3'");
        $result->bindParam("password",$contrasena3,PDO::PARAM_STR);
        $result->execute();
        $count = $result->rowCount();
        
        //Comprobamos si ha recogido valores en la variable count,
        //si recoge valores significa que está en la bd y
        //si no recoge ningún valor es que no
        //solo existirá habrá un 1 en count debido a que existe una restricción en el registro de usuarios dobles
        if($count){
            http_response_code(200);   
            $result1 = $conn->prepare("SELECT * FROM usuarios WHERE password='$contrasena4'");
            $result1->bindParam("password",$contrasena4,PDO::PARAM_STR);
            $result1->execute();
            $count = $result1->rowCount(); 
            if($count){ //Si hay un email igual ya registrado
                echo ' 
                    <script>
                        alert("El nombre de usuario no se encuentra registrado, inténtalo con otro diferente");
                        window.location = "../../index.html";
                    </script>
                ';
                exit();             
            }else{
                //Si no hay ni un nombre de usuario ni un email igual, entonces ejecutamos un insert sql query para realizar el registro
                $sql = "UPDATE usuarios Set password='$contrasena4' Where password='$contrasena3'";
                $result2 = $conn->exec($sql);

                if (!$result2) { //Si algo ha fallado
                    http_response_code(500);
                    echo ' 
                        <script>
                            alert("No se ha podido modificar, inténtelo de nuevo");
                            window.location = "../../index.html";
                        </script>
                    ';
                }
                else { //Si todo ha salido correctamente
                    http_response_code(200);
                    echo ' 
                        <script>
                            alert("Usuario modificado satisfactoriamente");
                            window.location = "../../index.html";
                        </script>
                    ';
                }
            }    
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