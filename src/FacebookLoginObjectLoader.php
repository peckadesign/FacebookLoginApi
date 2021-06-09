<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookLoginObjectLoader
{

	private \Pd\FacebookLoginApi\FacebookUserMapper $facebookUserMapper;

	private \Pd\FacebookLoginApi\Facebook $facebook;

	private \Pd\FacebookLoginApi\Config $config;


	public function __construct(
		\Pd\FacebookLoginApi\FacebookUserMapper $facebookUserMapper,
		\Pd\FacebookLoginApi\Facebook $facebook,
		\Pd\FacebookLoginApi\Config $config
	)
	{
		$this->facebookUserMapper = $facebookUserMapper;
		$this->facebook = $facebook;
		$this->config = $config;
	}


	/**
	 * @throws \Pd\FacebookLoginApi\Exception\NoAccessToken
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	public function load(?\Facebook\Authentication\AccessToken $accessToken = NULL): FacebookLoginObject
	{
		$acessToken = $accessToken ?: $this->facebook->getAccessToken();
		$graphUser = $this->facebook->getGraphUser($acessToken, $this->getEndPoint());

		return $this->facebookUserMapper->map($graphUser, $acessToken);
	}


	private function getEndPoint(): string
	{
		return \sprintf('/me?fields=%s', \implode(',', $this->config->getFields()));
	}

}
