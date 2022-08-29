<?php

namespace App\Service;

use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Action\LogoffAction;
use PAMI\Message\Action\UpdateConfigAction;

class UpdateConfig
{
    public static function createNewSNIP(string $number_provider,string $password_snip)
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

            $action = new UpdateConfigAction();
            $action->setAction('000000NewCat');
            $action->setCat('000000:auth'.$number_provider);
            $action->setCat('000001:auth'.$number_provider);
            $action->setAction('000001:append');
            $action->setVar('000001:type');
            $action->setValue('000001:auth');
            $action->setAction('000002:append');
            $action->setCat('000002:auth'.$number_provider);
            $action->setVar('000002:auth_type');
            $action->setValue('000002:userpass');
            $action->setCat('000003:auth'.$number_provider);
            $action->setVar('000003:password');
            $action->setValue('000003:'.$password_snip);
            $action->setAction('000004:append');
            $action->setVar('000004:username');
            $action->setValue('000004:'.$number_provider);

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
