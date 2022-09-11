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
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('no');
            $action->setAction('NewCat');
            $action->setCat(''.$number_provider);

            $client->send($action);

            $action = new UpdateConfigAction();
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('yes');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('secret');
            $action->setValue(''.$password_snip);
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('host');
            $action->setValue('dynamic');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('transport');
            $action->setValue('udp');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('type');
            $action->setValue('friend');
            $action->setAction('append');
            $action->setCat(''.$number_provider);
            $action->setVar('context');
            $action->setValue('outgoing');
            $action->setCat(''.$number_provider);
            $action->setAction('append');
            $action->setVar('nat');
            $action->setValue('force_rport,comedia');

            $client->send($action);

            $action2 = new LogoffAction;
            $client->send($action2);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }

    public static function updateSNIP(string $number_provider,string $password_snip){
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
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('yes');
            $action->setAction('Update');
            $action->setCat(''.$number_provider);
            $action->setVar('secret');
            $action->setValue(''.$password_snip);
            $action->setAction('Update');
            $action->setCat(''.$number_provider);
            $action->setVar('host');
            $action->setValue('dynamic');
            $action->setAction('Update');
            $action->setCat(''.$number_provider);
            $action->setVar('transport');
            $action->setValue('udp');
            $action->setAction('Update');
            $action->setCat(''.$number_provider);
            $action->setVar('type');
            $action->setValue('friend');
            $action->setAction('Update');
            $action->setCat(''.$number_provider);
            $action->setVar('context');
            $action->setValue('outgoing');
            $action->setCat(''.$number_provider);
            $action->setAction('Update');
            $action->setVar('nat');
            $action->setValue('force_rport,comedia');

            $client->send($action);

            $action2 = new LogoffAction;
            $client->send($action2);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }

    public static function deleteSNIP(string $number_provider){
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
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('yes');
            $action->setAction('DelCat');
            $action->setCat(''.$number_provider);

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
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('no');
            $action->setAction('NewCat');
            $action->setCat(''.$login.'(zadarma)');

            $client->send($action);

            $action = new UpdateConfigAction();
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('yes');
            $action->setAction('append');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('defaultuser');
            $action->setValue(''.$login);
            $action->setAction('append');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('trunkname');
            $action->setValue(''.$login);
            $action->setAction('append');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('fromuser');
            $action->setValue(''.$login);
            $action->setAction('append');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('callbackextension');
            $action->setValue(''.$login);
            $action->setAction('append');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('secret');
            $action->setValue(''.$password);

            $client->send($action);

            $action2 = new LogoffAction;
            $client->send($action2);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }

    public static function updateTrunk(string $sip_server, string $login, string $password)
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
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('yes');
            $action->setAction('Update');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('defaultuser');
            $action->setValue(''.$login);
            $action->setAction('Update');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('trunkname');
            $action->setValue(''.$login);
            $action->setAction('Update');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('fromuser');
            $action->setValue(''.$login);
            $action->setAction('Update');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('callbackextension');
            $action->setValue(''.$login);
            $action->setAction('Update');
            $action->setCat(''.$login.'(zadarma)');
            $action->setVar('secret');
            $action->setValue(''.$password);

            $client->send($action);

            $action2 = new LogoffAction;
            $client->send($action2);

            $client->close();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return true;
    }

    public static function deleteTrunk(string $login)
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
            $action->setSrcFilename('sip.conf');
            $action->setDstFilename('sip.conf');
            $action->setReload('yes');
            $action->setAction('DelCat');
            $action->setCat(''.$login.'(zadarma)');

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
