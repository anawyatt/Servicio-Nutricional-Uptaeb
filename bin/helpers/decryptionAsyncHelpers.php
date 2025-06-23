<?php
namespace helpers;

class decryptionAsyncHelpers {
    public static function decryptPayload($base64Payload) {
        $encryptedPayload = base64_decode($base64Payload);

        $privateKeyPath = realpath(__DIR__ . '/../config/secureKeys/private.pem');
        if (!$privateKeyPath || !file_exists($privateKeyPath)) {
            throw new \Exception("Archivo de llave privada no encontrado");
        }

        $privateKey = file_get_contents($privateKeyPath);

        $ok = openssl_private_decrypt($encryptedPayload, $decrypted, $privateKey);
        if (!$ok) {
            throw new \Exception("No se pudo descifrar el payload");
        }

        $data = json_decode($decrypted, true);
        if (!is_array($data)) {
            throw new \Exception("Payload desencriptado no es JSON válido");
        }

        return $data;
    }
}
