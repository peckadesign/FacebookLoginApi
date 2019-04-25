<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookLoginObjectLoader
{
	/**
	 * @var \Pd\FacebookLoginApi\FacebookUserMapper
	 */
	private $facebookUserMapper;

	/**
	 * @var \Pd\FacebookLoginApi\FacebookLoginResponseUserGetter
	 */
	private $facebookLoginResponseUserGetter;


	public function __construct(
		\Pd\FacebookLoginApi\FacebookUserMapper $facebookUserMapper,
		\Pd\FacebookLoginApi\FacebookLoginResponseUserGetter $facebookLoginResponseUserGetter
	)
	{
		$this->facebookUserMapper = $facebookUserMapper;
		$this->facebookLoginResponseUserGetter = $facebookLoginResponseUserGetter;
	}


	/**
	 * @throws \Pd\FacebookLoginApi\Exception\NoAccessToken
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	public function load(): FacebookLoginObject
	{
		$graphUser = $this->facebookLoginResponseUserGetter->get();

		return $this->facebookUserMapper->map($graphUser);
	}
}
