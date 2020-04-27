<?php
namespace app\traits;

trait traitSign
{
    private function signMessage($message)
    {
        /*
         * Подпись сообщения
         * $message - строка, сообщение для подписи
         * функция возвращает строку с подписью
         */

        $server_private_key  = ""; // путь к файлу с приватным ключем сервера
        $server_key_password = ""; // пароль от приватного ключа сервера

        $privateKeyId = openssl_get_privatekey($server_private_key, $server_key_password);

        openssl_sign($message, $out_sign_result, $privateKeyId);

        $sign_result_hex = unpack('H*', $out_sign_result);

        $hex = $sign_result_hex[1];

        return $hex;
    }

    private function verifySign($message, $sign, $publicKey)
    {
        /*
         * Верификация (проверка) подписи
         * $message - строка, сообщение которое было подписано
         * $sign - строка, подпись сообщения
         * $publicKey - строка, публичный ключ для снятия подписи
         * функция возвращает:
         * true если подпись верная
         * false если подпись не верная или возникла ошибка при снятии подписи
         */

        $binarySign = pack("H*", $sign);

        $test = openssl_verify($message, $binarySign, $publicKey);

        if ($test == 1) {
            return true;
        } elseif ($test == 0) {
            return false;
        } else {
            return false;
        }
    }
}
