<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class SessionAccessTokenStorage implements AccessTokenStorage
{
	/**
	 * @var \Nette\Http\SessionSection
	 */
	private $sessionSection;


	public function __construct(
		string $sessionSectionName,
		\Nette\Http\Session $session
	)
	{
		$this->sessionSection = $session->getSection($sessionSectionName);
	}


	public function get(): ?\Facebook\Authentication\AccessToken
	{
		return $this->sessionSection['facebookToken'] ?? NULL;
	}


	public function set(\Facebook\Authentication\AccessToken $token): void
	{
		$this->sessionSection['facebookToken'] = $token;

		$expiration = $token->getExpiresAt();

		if ( ! $expiration) {
			return;
		}

		$expiration = $expiration->format('U');

		$maxLifeTime = (int) \ini_get('session.gc_maxlifetime');

		if ($expiration > $maxLifeTime) {
			$expiration = $maxLifeTime;
		}

		$this->sessionSection->setExpiration($expiration);
	}
}
