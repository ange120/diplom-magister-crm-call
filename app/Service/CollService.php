<?php

namespace App\Service;

use Illuminate\Support\Facades\Artisan;

use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Action\OriginateAction;
use PAMI\Message\Action\LogoffAction;

class CollService
{
    public static function collUser(string $phone)
    {
        return true;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://example.com",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($phone),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
//            return "cURL Error #:" . $err;
            return false;
        } else {
            return true;
//            return json_decode($response);
        }
    }

    public static function collAsterisk(string $phoneManager, string $phone)
    {
        $options = array(
            'host' => env('ASTERISK_HOST'),
            'scheme' => 'tcp://',
            'port' => env('ASTERISK_PORT'),
            'username' => env('ASTERISK_USERNAME'),
            'secret' => env('ASTERISK_SECRET'),
            'connect_timeout' => env('ASTERISK_CONNECT_TIMEOUT'),
            'read_timeout' => env('ASTERISK_READ_TIMEOUT')
        );

        try {
            $client = new ClientImpl($options);
            $client->open();

            $action = new OriginateAction("Local/" . $phoneManager . "@hud-caller-answer");
            $action->setContext("pabx");
            $action->setExtension($phone);
            $action->setPriority('1');
            $action->setAsync(true);

            $client->send($action);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }


}
