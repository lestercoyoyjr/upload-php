<?php
    // IMPORTANT NOTICE
    // PLEASE ACTIVATE THE API IN GOOGLE DRIVE IN ORDER TO UPLOAD
    // YOUR FILE
    
    
    // to load and to use all the tools inside this api
    include "api-google/vendor/autoload.php";

    // our credentials goes in the 'x' from the json file name
    putenv('GOOGLE_APPLICATION_CREDENTIALS=xxxxxxxxxxxxxxxxxxxxxxx.json');

    // To create an instace from google client
    $client = new Google_Client();

    // to use the private key downloaded in json file
    $client->useApplicationDefaultCredentials();
    $client->setScopes(['https://www.googleapis.com/auth/drive.file']);

    try{
        // to connect with google drive
        $service = new Google_Service_Drive($client);
        $file_path = "imagen_prueba.jpg";

        
        $file = new Google_Service_Drive_DriveFile();
        $file->setName($file_path);

        // metadata
        // here it goes the info that appears in the link of the directory
        // where you're going to save it. You'll find it after the word
        // "folders"
        $file->setParents(array("1fAblezXonfrOM2u16CSlWLfnVKIMQCdy"));
        $file->setDescription("Archivo cargado desde PHP");
        $file->setMimeType("image/jpg");

        $resultado = $service->files->create(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => "image/jpg",
                'uploadType' => 'media'
            )
        );

        echo '<a href="https://drvie.google.com/open?id='.$resultado->id.'"target="_blank">'.$resultado->name.'</a>';

        // here it goes the exception
    } catch(Google_Service_Exception $gs){
        $mensaje = json_decode($gs->getMessage());
        echo $gs->getMessage();
    }catch(Exception $e){
        echo $e->getMessage();        
    }

?>