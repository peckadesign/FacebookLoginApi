<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class Facebook
{
	/**
	 * @var \Facebook\Facebook
	 */
	private $facebook;


	public function __construct(
		\Facebook\Facebook $facebook
	)
	{
		$this->facebook = $facebook;
	}


	public function setStateParam(?string $stateParam): void
	{
		$this
			->facebook
			->getRedirectLoginHelper()
			->getPersistentDataHandler()
			->set('state', $stateParam)
		;
	}


	public function getLoginUrl(string $redirectUrl, array $permissions): string
	{
		return $this->facebook
			->getRedirectLoginHelper()
			->getLoginUrl($redirectUrl, $permissions)
			;
	}


	public function getLoginReRequestUrl(string $redirectUrl, array $permissions): string
	{
		return $this->facebook
			->getRedirectLoginHelper()
			->getReRequestUrl($redirectUrl, $permissions)
			;
	}


	/**
	 * @throws \Pd\FacebookLoginApi\Exception\NoAccessToken
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	public function getGraphUser(
		\Facebook\Authentication\AccessToken $accessToken,
		string $endPoint
	): \Facebook\GraphNodes\GraphUser
	{
		$facebook = $this->facebook;

		$facebookResponse = $facebook->get($endPoint, $accessToken);

		return $facebookResponse->getGraphUser();
	}


	/**
	 * @throws \Pd\FacebookLoginApi\Exception\NoAccessToken
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	public function getAccessToken(): \Facebook\Authentication\AccessToken
	{
		$helper = $this->facebook->getRedirectLoginHelper();

		$token = $helper->getAccessToken();

		if ($token === NULL) {
			throw new \Pd\FacebookLoginApi\Exception\NoAccessToken('_message_facebook_no_access_token');
		}

		return $this->getLongLifeValidatedToken($token);
	}


	public function getStoredRequest(): ?string
	{
		$helper = $this->facebook->getRedirectLoginHelper();

		return $helper->getPersistentDataHandler()->get('state');
	}


	/**
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	private function getLongLifeValidatedToken(\Facebook\Authentication\AccessToken $accessToken): \Facebook\Authentication\AccessToken
	{
		$oAuth2Client = $this->facebook->getOAuth2Client();

		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		$tokenMetadata->validateAppId($this->facebook->getApp()->getId());
		$tokenMetadata->validateExpiration();

		if ( ! $accessToken->isLongLived()) {
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		}

		return $accessToken;
	}
}
