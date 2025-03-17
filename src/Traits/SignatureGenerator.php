<?php

namespace Devadze\FlittPayment\Traits;

trait SignatureGenerator
{
    const SIGNATURE_SEPARATOR = '|';
    public function generateSignature($data, $password, $encoded = true): string
    {
        $data = array_filter($data, function($var) {
            return $var !== '' && $var !== null;
        });
        ksort($data);

        $str = $password;
        foreach ($data as $k => $v) {
            $str .= self::SIGNATURE_SEPARATOR . $v;
        }

        if ($encoded) {
            return sha1($str);
        } else {
            return $str;
        }
    }


}
