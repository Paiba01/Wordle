<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Blog</title>
</head>
<body>
    <h2>Nueva entrada</h2>
    <form action="insertar_contenido.php" method="post"
    enctype="multipart/form-data" name="form1">
    <table>
        <tr>
            <td>Título:
                <label for="campo_titulo"></label>
            </td>
            <td><input type="text" name="campo_titulo" id="campo_titulo"></td>
        </tr>
        <tr>
            <td>Comentario:
                <label for="area_comentarios"></label>
            </td>
            <td><textarea name="area_comentarios" id="area_comentarios" rows="10" cols="50"></textarea></td>
        </tr>
        <input type="hidden" name="MAX_TAM" value="2097152">
        <tr>
            <td>Username:
                <label for="campo_username"></label>
            </td>
            <td><input type="text" name="campo_username" id="campo_username"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
            <input type="submit" name="btn_enviar" id="btn_enviar" value="Enviar"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><a href="mostrar_blog.php">Página de visualización del blog</a></td>
        </tr>
    </table>
</form>
<p>&nbsp;</p>
</body>
</html>