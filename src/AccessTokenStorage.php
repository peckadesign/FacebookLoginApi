<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

interface AccessTokenStorage
{
	public function get(): ?\Facebook\Authentication\AccessToken;

	public function set(\Facebook\Authentication\AccessToken $token): void;
}
