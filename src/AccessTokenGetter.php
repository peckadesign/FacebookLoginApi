<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class AccessTokenGetter
{
	/**
	 * @var \Pd\FacebookLoginApi\AccessTokenStorage
	 */
	private $accessTokenStorage;


	/**
	 * @var \Pd\FacebookLoginApi\Facebook
	 */
	private $facebook;


	public function __construct(
		\Pd\FacebookLoginApi\Facebook $facebook,
		\Pd\FacebookLoginApi\AccessTokenStorage $accessTokenStorage
	)
	{
		$this->facebook = $facebook;
		$this->accessTokenStorage = $accessTokenStorage;
	}


	/**
	 * @throws \Pd\FacebookLoginApi\Exception\NoAccessToken
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	public function get(): \Facebook\Authentication\AccessToken
	{
		$sessionToken = $this->accessTokenStorage->get();

		if ($sessionToken) {
			return $sessionToken;
		}

		$token = $this->facebook->getAccessToken();

		$this->accessTokenStorage->set($token);

		return $token;
	}
}
