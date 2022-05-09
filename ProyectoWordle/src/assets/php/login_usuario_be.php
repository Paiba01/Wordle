<?php
    $servername = "localhost";
    $username = "id18899575_p92dogoj";
    $password = "acd//a-|^0pW|@3A";
    $database = "id18899575_wordlebd";

    try {          
        //Gets the insertion data
        $username2 = $_POST["username"];
        $password2 = $_POST["password"];
        
        if ($username2 == "" || $password2 == "") {
            http_response_code(400);
            echo "Bad Request";
            return;
        }

        //tries to connect to the databse
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Executes an insert sql query
        //$table = "usuarios";
        //$sql = "SELECT * FROM usuarios WHERE username='$username2' AND password='$password2'";
        //$result = $conn->query($sql);

        $result = $conn->prepare("SELECT * FROM usuarios WHERE username='$username2' AND password='$password2'");
        $result->bindParam("username",$username2,PDO::PARAM_STR);
        $result->bindParam("password",$password2,PDO::PARAM_STR);
        $result->execute();
        $count = $result->rowCount();
        
        if($count){
            echo ' 
                <script>
                    alert("Sesión iniciada correctamente");
                    window.location = "../../wordle.html";
                </script>
            ';
        }else{
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