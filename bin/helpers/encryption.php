<?php 

namespace helpers;

class encryption{

   private $cipher = "aes-256-cbc";

    private function getKey() {
        return hash('sha256', getenv('SECRET_KEY'), true); 
    }

    private function getIV() {
    return substr(hash('sha256', $this->getKey(), true), 0, openssl_cipher_iv_length($this->cipher));
    }

    public function encryptURL($url) {
        $cipher = "aes-256-cbc";
        $key = $this->getKey();
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($url, $cipher, $key, 0, $iv);
        return urlencode(base64_encode($iv . $encrypted));
    }

    public function decryptURL($encryptedURL) {
      $cipher = "aes-256-cbc";
      $key = $this->getKey();
      $data = base64_decode(urldecode($encryptedURL));
      $iv = substr($data, 0, 16);
      $encrypted = substr($data, 16);
      return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
    }

  public function encryptData($dato) {
    $cipher = "aes-256-cbc";
    $key = $this->getKey();
    $iv = $this->getIV();
    $encrypted = openssl_encrypt($dato, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encrypted);
}

public function decryptData($datoCifrado) {
    $cipher = "aes-256-cbc";
    $key = $this->getKey();
    $iv =$this->getIV();
    $encrypted = base64_decode($datoCifrado);
    return openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
}



}


?>
