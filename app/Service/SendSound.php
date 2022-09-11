<?php

namespace App\Service;

class SendSound
{
    public static function sendVoice(string $audio, string $phone_manager)
    {
        $data = array("voiceData" => $audio, 'phone_manager' => $phone_manager);
        $data_string = json_encode($data);
        $ch = curl_init('https://example.com');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')
        );
        $result = curl_exec($ch);
        return true;
    }
}
