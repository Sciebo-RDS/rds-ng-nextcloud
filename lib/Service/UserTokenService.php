<?php

namespace OCA\RdsNg\Service;

use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Core\Util\RSAKey;

class UserToken {
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

    public function generateUserToken(): UserToken {
        $jwk = RSAKey::createFromJWK(JWKFactory::createRSAKey(4096));
        return new UserToken(RSAKey::toPublic($jwk)->toPEM(), $jwk->toPEM());
    }
}
