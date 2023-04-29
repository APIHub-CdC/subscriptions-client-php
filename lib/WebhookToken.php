<?php
namespace CirculoDeCredito\Subscriptions\Client;

/**
 * 
 */
class WebhookToken {

    private const ENCRYPTION_ALGORITHM = "aes-256-gcm";

    private $privateKey;
    private $publicKey;

    /**
     * 
     */
    public function __construct($publicKeyFile, $pkcs12File, $password) {
        $cryptoVault = file_get_contents($pkcs12File); // Yout PKCS12 vault file
        $pkcs12 = null;
        $readKeysSuccess = openssl_pkcs12_read($cryptoVault, $pkcs12, $password);

        if (!$readKeysSuccess) {
            print("[ERROR] Extraction of cryptographic keys failed, something went wrong..\n");

            throw new Exception('Extraction of cryptographic keys failed, incorrect pkcs12 file or password.');
        }
        
        $this->privateKey   = $pkcs12["pkey"];
        $this->publicKey    = openssl_pkey_get_public(file_get_contents($publicKeyFile));
    }

    /**
     * 
     */
    public function generateJwtAuth($username, $password): string {
        $sharedSecret = openssl_pkey_derive($this->publicKey, $this->privateKey);
        print("[INFO ] Loading encryption data ... \n");

        $plaintext = '{"username":"'.$username.'","password":"'.$password.'"}';
        $cipher    = self::ENCRYPTION_ALGORITHM;

        $iv = random_bytes(16);

        print("[INFO ] Encrypting data ...\n");

        $encryptedData = openssl_encrypt($plaintext, $cipher, $sharedSecret, OPENSSL_RAW_DATA, $iv, $tag);

        $ivBase64 = base64_encode($iv);
        $encryptedAsHex = bin2hex($encryptedData.$tag);

        $webhookJwtAuth = "$encryptedAsHex.$ivBase64";

        print("[INFO ] Header x-webhook-jwt-auth: $webhookJwtAuth \n");
        
        return $webhookJwtAuth;
    }
}
