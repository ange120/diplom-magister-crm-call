<?php

namespace App\Service;
use CURLFile;
class SendSound
{
    public static function sendVoice(string $audio, string $phone_manager)
    {
        $newFile =  substr(stristr($audio, '/'), 1);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.137.23/'.$newFile,
            CURLOPT_RETURNTRANSFER => '1',
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => array(new CURLFILE($newFile)),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return true;
    }
}
