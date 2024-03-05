<?php

namespace OCA\RdsNg\Service;

require_once __DIR__ . '/../../vendor/autoload.php';

use JsonSerializable;

use OCP\IUserSession;

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

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

    public function privateKey(): string {
        return $this->privateKey;
    }
}

class UserToken implements JsonSerializable {
    private string $userID = "";
    private string $name = "";

    public function userID(): string {
        return $this->userID;
    }

    public function name(): string {
        return $this->name;
    }

    public static function fromSession(IUserSession $session, AppService $appService): UserToken {
        $token = new UserToken();

        $token->userID = $appService->normalizeUserID($session->getUser()->getUID());
        $token->name = $session->getUser()->getDisplayName();

        return $token;
    }

    public function generateJWT(UserTokenKeys $keys): string {
        $payload = json_encode([
            "iss" => "RDS NG",
            "sub" => "User Token",
            "user-token" => $this->token(),
        ]);

        $algorithmManager = new AlgorithmManager([new RS256()]);
        $jwsBuilder = new JWSBuilder($algorithmManager);
        $jws = $jwsBuilder
            ->create()
            ->withPayload($payload)
            ->addSignature(JWK::createFromJson($keys->privateKey()), ["alg" => "RS256"])
            ->build();
        $serializer = new CompactSerializer();
        return $serializer->serialize($jws, 0);
    }

    public function token(): array {
        return [
            "user-id" => $this->userID,
            "user-name" => $this->name,
        ];
    }

    public function jsonSerialize(): array {
        return $this->token();
    }
}

class UserTokenService {
    private IUserSession $userSession;

    private AppService $appService;

    public function __construct(IUserSession $userSession, AppService $appService) {
        $this->userSession = $userSession;

        $this->appService = $appService;
    }

    public function generateUserToken(): UserToken {
        return UserToken::fromSession($this->userSession, $this->appService);
    }

    public function generateUserTokenKeys(): UserTokenKeys {
        $jwk = JWKFactory::createRSAKey(
            2048,
            [
                "alg" => "RS256",
                "use" => "sig"
            ]
        );
        return new UserTokenKeys(json_encode($jwk->toPublic()), json_encode($jwk));
    }
}
