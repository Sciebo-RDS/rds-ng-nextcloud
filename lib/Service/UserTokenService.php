<?php

namespace OCA\RdsNg\Service;

require_once __DIR__ . '/../../vendor/autoload.php';

use Jose\Component\KeyManagement\JWKFactory;

class UserTokenKeys {
    private string $publicKey;
    private string $privateKey;

    public function __construct(string $publicKey, string $privateKey) {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function publicKey(): string {
        return $this->publicKey;
    }

    public function privateKey() {
        return $this->privateKey;
    }
}

class UserTokenService {
    public function __construct() {
    }

    public function generateUserTokenKeys(): UserTokenKeys {
        $jwk = JWKFactory::createRSAKey(
            2048,
            [
                "alg" => "RSA-OAEP-256",
                "use" => "sig"
            ]
        );
        return new UserTokenKeys(json_encode($jwk->toPublic()), json_encode($jwk));
    }
}
