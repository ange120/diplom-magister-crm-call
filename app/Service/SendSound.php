<?php

namespace App\Service;

use CURLFile;

class SendSound
{
    public static function sendVoice(string $audio, string $phone_manager)
    {
        try {
            shell_exec("curl -X PUT http://192.168.137.23/ --upload-file ".$audio);

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }

    public static function deleteVoice(string $FileName, string $phone_manager)
    {
        try {
            shell_exec("curl -X DELETE http://192.168.137.23/".$FileName);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }
}
