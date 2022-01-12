<?php
    // IMPORTANT NOTICE
    // PLEASE ACTIVATE THE API IN GOOGLE DRIVE IN ORDER TO UPLOAD
    // YOUR FILE

    // PLEASE CHECK YOUR PHP.INI FILE TO REVIEW TOW THINGS
    // max_execution_time=120 OR BIGGER
    // post_max_size=40M OR BIGGER
    // upload_max_filesize=50M OR BIGGER DEPENDING OR YOUR FILE SIZE
    
    // to include the mysql connection
    require 'conexion.php';
    // to load and to use all the tools inside this api
    include "api-google/vendor/autoload.php";

    // our credentials goes in the 'x' from the json file name
    // and move it to this directory
    putenv('GOOGLE_APPLICATION_CREDENTIALS=xxxxxxxxxxxxxxxxxxxxxxxxxx.json');

    // To create an instace from google client
    $client = new Google_Client();

    // to use the private key downloaded in json file
    $client->useApplicationDefaultCredentials();
    $client->setScopes(['https://www.googleapis.com/auth/drive.file']);

    try{
        // a name for the file to make our insertion faster
        $nombre = $_FILES['archivos']['name'];
        // the extension
        $extension = $_FILES['archivos']['type'];

        // to connect with google drive
        $service = new Google_Service_Drive($client);
        $file_path = $_FILES['archivos']['tmp_name'];

        
        $file = new Google_Service_Drive_DriveFile();
        $file->setName($nombre);

        // to upload any kind of file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_path);

        // metadata
        // here it goes the info that appears in the link of the directory
        // where you're going to save it. You'll find it after the word
        // "folders"
        $file->setParents(array("1fAblezXonfrOM2u16CSlWLfnVKIMQCdy"));
        $file->setDescription("Archivo cargado desde PHP");
        
        // $file->setMimeType("image/jpg");
        $file->setMimeType($mime_type);

        $resultado = $service->files->create(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type,
                'uploadType' => 'media'
            )
        );

        // path
        $ruta = 'https://drvie.google.com/open?id='.$resultado->id;

        // insert for mysql
        $sql = "INSERT INTO archivos(nombre, ruta, extension) VALUES ('$nombre','$ruta', '$mime_type')";
        //execute query
        $mysqli->query($sql);

        echo '<a href="'.$ruta.'"target="_blank">'.$resultado->name.'</a>';

        // here it goes the exception
    } catch(Google_Service_Exception $gs){
        $mensaje = json_decode($gs->getMessage());
        echo $gs->getMessage();
    }catch(Exception $e){
        echo $e->getMessage();        
    }

?>