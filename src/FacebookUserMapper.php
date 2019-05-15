<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookUserMapper
{
	public function map(
		\Facebook\GraphNodes\GraphUser $graphUser,
		\Facebook\Authentication\AccessToken $accessToken
	): FacebookLoginObject
	{
		$facebookUser = new FacebookLoginObject(
			$graphUser->getId(),
			$graphUser->getEmail(),
			$graphUser->getFirstName(),
			$graphUser->getLastName(),
			$accessToken
		);

		return $facebookUser;
	}
}
