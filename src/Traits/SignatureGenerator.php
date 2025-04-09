<?php

namespace Devadze\FlittPayment\Traits;

trait SignatureGenerator
{
    const SIGNATURE_SEPARATOR = '|';
    public function generateSignature($params, $encoded = true): string
    {
        $data = array_filter($params,
            function ($var) {
                return $var !== '' && $var !== null;
            });
        ksort($data);
        $sign_str = config('flitt.secret_key');
        foreach ($data as $k => $v) {
            $sign_str .= self::SIGNATURE_SEPARATOR . $v;
        }
        if ($encoded) {
            $signature = sha1($sign_str);
        } else {
            $signature = $sign_str;
        }

        return $signature;
    }


}
