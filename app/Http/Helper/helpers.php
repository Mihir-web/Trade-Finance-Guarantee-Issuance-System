<?php

use Illuminate\Support\Facades\Schema;
// use App\permissions;
// use App\modules;
// use App\images;
// use App\activity_logs;
// use App\aliases;



function getEncryptedString($text)
{
    $encryptedSring = '';
    if (!empty($text)) {
//        $envKey = env('APP_KEY');
        $envKey = config('app.key');
        $method = 'aes-256-cbc';
        // Must be exact 32 chars (256 bit)
        $secureEnvKey = substr(hash('sha256', $envKey, true), 0, 32);
        // IV must be exact 16 chars (128 bit)
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $encryptedSring = base64_encode(openssl_encrypt($text, $method, $secureEnvKey, OPENSSL_RAW_DATA, $iv));
    }
    return $encryptedSring;
}

function getDecryptedString($text)
{
    $decryptedSring = '';
    if (!empty($text)) {
        $envKey = env('APP_KEY');
        $method = 'aes-256-cbc';
        // Must be exact 32 chars (256 bit)
        $secureEnvKey = substr(hash('sha256', $envKey, true), 0, 32);
        // IV must be exact 16 chars (128 bit)
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $decryptedSring = openssl_decrypt(base64_decode($text), $method, $secureEnvKey, OPENSSL_RAW_DATA, $iv);
    }
    return $decryptedSring;
}

function getClientIp() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

?>