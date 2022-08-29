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
            $action->setAction('NewCat');
            $action->setCat('auth'.$number_provider);
            $action->setCat('auth'.$number_provider);
            $action->setAction('append');
            $action->setVar('type');
            $action->setValue('auth');
            $action->setAction('append');
            $action->setCat('auth'.$number_provider);
            $action->setVar('auth_type');
            $action->setValue('userpass');
            $action->setCat('auth'.$number_provider);
            $action->setVar('password');
            $action->setValue($password_snip);
            $action->setAction('append');
            $action->setVar('username');
            $action->setValue($number_provider);

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
