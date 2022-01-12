<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Subir Archivos a Google Drive</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <p>
            Archivos:
            <input type="file" name="archivos">
        </p>

        <p>
            <button type="submit">Enviar</button>
        </p>

    </form>
</body>
</html>