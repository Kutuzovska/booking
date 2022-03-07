<?php
declare(strict_types=1);

namespace app\modules\v1\components;

use Exception;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use yii\base\BaseObject;

class JWT extends BaseObject
{
    public string $key;
    private Configuration $jwt;
    private Sha256 $signer;
    private InMemory $signer_key;

    public function __construct(array $config)
    {
        $this->signer = new Sha256();
        $this->signer_key = InMemory::plainText((string) $config['key']);
        $this->jwt = Configuration::forSymmetricSigner($this->signer, $this->signer_key);
        parent::__construct($config);
    }

    public function getBuilder(): Builder
    {
        return $this->jwt->builder();
    }

    public function getSinger(): Sha256
    {
        return $this->signer;
    }

    public function getSingerKey(): InMemory
    {
        return $this->signer_key;
    }

    /**
     * @throws Exception
     */
    public function validate(string $token): UnencryptedToken
    {
        $token = $this->jwt->parser()->parse($token);
        if (!$this->jwt->validator()->validate($token, new SignedWith($this->signer, $this->signer_key)))
            throw new Exception('Invalid token');

        return $token;
    }
}
