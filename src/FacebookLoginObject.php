<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookLoginObject
{
	/**
	 * @var NULL|string
	 */
	private $facebookId;

	/**
	 * @var NULL|string
	 */
	private $email;

	/**
	 * @var NULL|string
	 */
	private $firstName;

	/**
	 * @var NULL|string
	 */
	private $lastName;

	/**
	 * @var \Facebook\Authentication\AccessToken
	 */
	private $accessToken;


	public function __construct(
		?string $facebookId,
		?string $email,
		?string $firstName,
		?string $lastName,
		\Facebook\Authentication\AccessToken $accessToken
	)
	{
		$this->email = $email;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->facebookId = $facebookId;
		$this->accessToken = $accessToken;
	}


	public function getFacebookId(): ?string
	{
		return $this->facebookId;
	}


	public function getEmail(): ?string
	{
		return $this->email;
	}


	public function getFirstName(): ?string
	{
		return $this->firstName;
	}


	public function getLastName(): ?string
	{
		return $this->lastName;
	}


	public function setEmail(string $email): void
	{
		$this->email = $email;
	}


	public function getAccessToken(): \Facebook\Authentication\AccessToken
	{
		return $this->accessToken;
	}
}
