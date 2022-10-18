<?php

namespace App\Services;

use App\Exceptions\UploadFileException;

class UploadPhotoPlaylistService
{

    function uploadFile($file)
    {

        //We throw a personal Exception if the file is null
        if ($file == null)
            throw new UploadFileException('File not defined');

        $destinationPath = 'storage/playlist/covers';
        $originalFile = $file->getClientOriginalName();
        $file->move($destinationPath, $originalFile);
    }
}