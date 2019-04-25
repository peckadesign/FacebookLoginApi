<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookLoginReRequestLinkFactory
{
	/**
	 * @var array
	 */
	private $permissions;

	/**
	 * @var \Nette\Application\LinkGenerator
	 */
	private $linkGenerator;

	/**
	 * @var \Pd\FacebookLoginApi\Facebook
	 */
	private $facebook;

	public function __construct(
		\Pd\FacebookLoginApi\Config $config,
		\Nette\Application\LinkGenerator $linkGenerator,
		\Pd\FacebookLoginApi\Facebook $facebook
	)
	{
		$this->permissions = $config->getPermissions();
		$this->linkGenerator = $linkGenerator;
		$this->facebook = $facebook;
	}


	/**
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 */
	public function createRequestLink(string $destination): string
	{
		static $url;

		if ($url === NULL) {
			$url = $this->getLoginUrl($destination);
		}

		return $url;
	}


	private function getLoginUrl(string $destination): string
	{
		$redirectUrl = $this->linkGenerator->link($destination);

		return $this->facebook
			->getLoginReRequestUrl($redirectUrl, $this->permissions)
		;
	}
}
