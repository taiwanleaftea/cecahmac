<?php

namespace TLT\Cecahmac;

use Exception;

class Hmac
{
    /**
     * Encryption key in binary format (decoded)
     * @var string
     */
    private $encryptionKey;

    /**
     * @param string $encryptionKey
     */
    public function __construct($encryptionKey)
    {
        $this->encryptionKey = base64_decode($encryptionKey);
    }

    /**
     * @param $dataToSign
     * @param $operationNumber
     * @return string
     * @throws Exception
     */
    public function makeSignature($dataToSign, $operationNumber)
    {
        return base64_encode(hash_hmac('sha256', $dataToSign, $this->generate3DESKey($operationNumber), true));
    }

    /**
     * @param $data
     * @param $binary
     * @return false|string
     * @throws Exception
     */
    public function generate3DESKey($data, $binary = true)
    {
        $pad = 8 - (strlen($data) % 8);

        if ($pad === 8) {
            $pad = 0;
        }

        $data .= str_repeat(chr(0), $pad);

        $key = openssl_encrypt($data, 'des-ede3-cbc', $this->encryptionKey, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $this->makeIV());

        if (!$binary) {
            $key = bin2hex($key);
        }

        return $key;
    }

    /**
     * @param $value
     * @return string
     * @throws Exception
     */
    private function makeIV($value = '0000000000000000')
    {
        $iv = hex2bin($value);

        if ($iv === false) {
            throw new Exception('Unable to generate Initialization Vector. Input is not a hex string.');
        }

        return $iv;
    }
}