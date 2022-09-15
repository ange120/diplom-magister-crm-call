<?php

namespace App\Service;

use App\Models\VoiceRecord;
use Illuminate\Support\Facades\Artisan;

use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Action\OriginateAction;
use PAMI\Message\Action\LogoffAction;

class CollService
{
    public static function collAsteriskVoice(string $phoneManager, string $phone, int $voice_id, string $trunk_login)
    {

        $voice = VoiceRecord::find($voice_id)->text;

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

            $action = new OriginateAction("SIP/".$phone.'@siplink');
            $action->setContext("outgoing");
            $action->setVariable('VOICE', $voice);
            $action->setVariable('MANAGER',$phoneManager);
            $action->setExtension('s');
            $action->setPriority('1');

            $client->send($action);

            $action2 = new LogoffAction;
            $client->send($action2);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
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
            $actionid = md5(uniqid());
            $client = new ClientImpl($options);
            $client->open();

            $action = new OriginateAction("Local/" . $phoneManager . "@pabx");
            $action->setContext("pabx");
            $action->setExtension($phone);
            $action->setCallerId($phone);
            $action->setPriority('1');
            $action->setAsync(true);
            $action->setActionID($actionid);

            $client->send($action);

            $action2 = new LogoffAction;
            $client->send($action2);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }


}

