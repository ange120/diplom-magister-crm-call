<?php

namespace App\Service;

use CURLFile;

class SendSound
{
    public static function sendVoice(string $audio, string $phone_manager)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://192.168.137.23/webdav/',
                CURLOPT_RETURNTRANSFER => '1',
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => array(new CURLFILE($audio)),
            ));

            curl_exec($curl);
            curl_close($curl);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }
}
