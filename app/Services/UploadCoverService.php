<?php

namespace App\Services;

use App\Exceptions\UploadFileException;

class UploadCoverService
{

    function uploadFile($file)
    {

        //We throw a personal Exception if the file is null
        if ($file == null)
            throw new UploadFileException('File not defined');

        //Guardamos la musica en la carpeta publica storage y cremos dentro una carpeta llamada uploads
        $destinationPath = 'storage/music/covers';
        $originalFile = $file->getClientOriginalName();
        $file->move($destinationPath, $originalFile);
    }
}