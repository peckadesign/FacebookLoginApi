<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookLoginResponseUserGetter
{
	/**
	 * @var \Pd\FacebookLoginApi\Config
	 */
	private $config;

	/**
	 * @var \Pd\FacebookLoginApi\Facebook
	 */
	private $facebook;

	/**
	 * @var \Pd\FacebookLoginApi\AccessTokenGetter
	 */
	private $sessionStoredAccessTokenGetter;


	public function __construct(
		\Pd\FacebookLoginApi\Config $config,
		\Pd\FacebookLoginApi\AccessTokenGetter $sessionStoredAccessTokenGetter,
		\Pd\FacebookLoginApi\Facebook $facebook
	)
	{
		$this->config = $config;
		$this->sessionStoredAccessTokenGetter = $sessionStoredAccessTokenGetter;
		$this->facebook = $facebook;
	}


	/**
	 * @throws \Pd\FacebookLoginApi\Exception\NoAccessToken
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	public function get(): \Facebook\GraphNodes\GraphUser
	{
		return $this->facebook
			->getGraphUser($this->sessionStoredAccessTokenGetter->get(), $this->getEndPoint())
		;
	}


	private function getEndPoint(): string
	{
		return \sprintf('/me?fields=%s', \implode(',', $this->config->getFields()));
	}
}
