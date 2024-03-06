<?php

namespace OCA\RdsNg\Types;

class KeyPair {
    private string $publicKey;
    private string $privateKey;

    public function __construct(string $publicKey, string $privateKey) {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function publicKey(): string {
        return $this->publicKey;
    }

    public function privateKey(): string {
        return $this->privateKey;
    }
}
