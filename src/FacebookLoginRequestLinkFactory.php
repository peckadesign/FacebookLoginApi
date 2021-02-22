<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookLoginRequestLinkFactory
{
	/**
	 * @var string[]
	 */
	private $permissions;

	/**
	 * @var string
	 */
	private $loginUrlDestination;

	/**
	 * @var \Pd\FacebookLoginApi\LinkGeneratorInterface
	 */
	private $linkGenerator;

	/**
	 * @var \Pd\FacebookLoginApi\Facebook
	 */
	private $facebook;

	public function __construct(
		\Pd\FacebookLoginApi\Config $config,
		\Pd\FacebookLoginApi\LinkGeneratorInterface $linkGenerator,
		Facebook $facebook
	)
	{
		$this->permissions = $config->getPermissions();
		$this->loginUrlDestination = $config->getLoginUrlDestination();
		$this->linkGenerator = $linkGenerator;
		$this->facebook = $facebook;
	}


	/**
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 * @throws \Nette\Application\UI\InvalidLinkException
	 */
	public function createRequestLink(?string $stateParam): string
	{
		static $url;

		if ($url === NULL) {
			$this->facebook->setStateParam($stateParam);
			$url = $this->getLoginUrl();
		}

		return $url;
	}


	/**
	 * @throws \Facebook\Exceptions\FacebookSDKException
	 * @throws \Nette\Application\UI\InvalidLinkException
	 */
	private function getLoginUrl(): string
	{
		$redirectUrl = $this->linkGenerator->link($this->loginUrlDestination);

		return $this->facebook
			->getLoginUrl($redirectUrl, $this->permissions)
			;
	}
}
