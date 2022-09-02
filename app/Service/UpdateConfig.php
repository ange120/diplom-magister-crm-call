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
            $action->setSrcFilename('pjsip.conf');
            $action->setDstFilename('pjsip.conf');
            $action->setReload('no');
            $action->setAction('NewCat');
            $action->setCat(''.$number_provider);

            $client->send($action);

            $action = new UpdateConfigAction();
            $action->setSrcFilename('pjsip.conf');
            $action->setDstFilename('pjsip.conf');
            $action->setReload('no');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('type');
            $action->setValue('endpoint');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('transport');
            $action->setValue('udp-transport');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('context');
            $action->setValue('from-internal');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('auth');
            $action->setValue('auth'.$number_provider);
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('aors');
            $action->setValue(''.$number_provider);

            $client->send($action);

            $action = new UpdateConfigAction();
            $action->setSrcFilename('pjsip.conf');
            $action->setDstFilename('pjsip.conf');
            $action->setReload('yes');
            $action->setAction('NewCat');
            $action->setCat('auth'.$number_provider);
            $action->setAction('append');
            $action->setCat('auth'.$number_provider);
            $action->setVar('type');
            $action->setValue('auth');
            $action->setAction('append');
            $action->setCat('auth'.$number_provider);
            $action->setVar('auth_type');
            $action->setValue('userpass');
            $action->setAction('append');
            $action->setCat('auth'.$number_provider);
            $action->setVar('password');
            $action->setValue(''.$password_snip);
            $action->setAction('append');
            $action->setCat('auth'.$number_provider);
            $action->setVar('username');
            $action->setValue(''.$number_provider);

            $client->send($action);

            $action2 = new LogoffAction;
            $client->send($action2);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }

    public static function createTrunk(string $sip_server, string $login, string $password)
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
