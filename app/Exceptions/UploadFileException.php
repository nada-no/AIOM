<?php

namespace App\Exceptions;

use Exception;

class UploadFileException extends Exception 
{
    public function customMessage(){
        return 'Error to upload';
    }
}