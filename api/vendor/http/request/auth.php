<?php

namespace Request;

class Auth {

    use \Facade;

    private function sign(array $payload, string $exp='1d', string $alg='HS256'){

        if(!array_key_exists('sub',$payload)){
            return false;
        }

        $header = json_encode([
            'alg' => $alg,
            'typ' => 'JWT'
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        if(!array_key_exists('exp',$payload)){
            $payload['exp'] = $exp;
        }
        
        $payload['exp'] = convertToSeconds($payload['exp']);

        $json_payload = json_encode($payload);

        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($json_payload));

        $secretKey = env('JWT_SECRET');
        $signature = '';
        if($alg == 'HS256'){
        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secretKey, true);
        }
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

    }

    
    private function verify(string $token, array | null $options = null){
        $jwtParts = explode('.', $token);
        if (count($jwtParts) !== 3 || empty($jwtParts[2])) {
          return false;
        }
        $header = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $jwtParts[0])), true);
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $jwtParts[1])), true);
        $signatureProvided = $jwtParts[2];
        if (!$header || !$payload) {
           return false;
        }
        $base64UrlHeader = $jwtParts[0];
        $base64UrlPayload = $jwtParts[1];
        $signatureCheck = '';
        if(is_array($options) && array_key_exists('alg',$options)){
        if($options['alg'] == 'HS256'){
        $signatureCheck = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", env('JWT_SECRET'), true);
        }
        }else{
        $signatureCheck = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", env('JWT_SECRET'), true);
        }
        $base64UrlSignatureCheck = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signatureCheck));

        if ($base64UrlSignatureCheck !== $signatureProvided) {
         return false;
        }
       
        $decodedPayload = json_decode($payload, true);
        if (!isset($decodedPayload['exp']) || $decodedPayload['exp'] < time()) {
        return false;
        }

        return new \Request\User($decodedPayload);

    }


    /* private function user() : mixed {
        $user = $GLOBALS['authUser'] ?? null;
    } */

}
