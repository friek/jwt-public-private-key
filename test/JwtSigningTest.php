<?php

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use PHPUnit\Framework\TestCase;

class JwtSigningTest extends TestCase
{
	/**
	 * @var string
	 */
	private $keyDir;
	/**
	 * @var Key
	 */
	private $privateKey;
	/**
	 * @var Key
	 */
	private $publicKey;
	/**
	 * @var Sha256
	 */
	private $signer;
	/**
	 * @var Builder
	 */
	private $builder;

	public function setUp(): void
	{
		$this->signer = new Sha256();

		$this->keyDir = __DIR__ . '/../key';
		$this->privateKey = new Key('file://' . $this->keyDir . '/key.pem', '');
		$this->publicKey = new Key('file://' . $this->keyDir . '/key.pub');

		$this->builder = new Builder();
	}

	public function testSigningAndVerifications()
	{
		$now = time();
		$token = $this->builder->issuedAt($now)
		                       ->expiresAt($now + 3600)
		                       ->withClaim('uid', 1)
		                       ->getToken($this->signer, $this->privateKey);
		$this->assertNotNull($token);

		$this->assertTrue($token->verify($this->signer, $this->publicKey));

		file_put_contents($this->keyDir . '/token.jwt', $token->__toString());
	}
}