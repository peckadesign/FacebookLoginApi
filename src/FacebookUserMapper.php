<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class FacebookUserMapper
{
	public function map(\Facebook\GraphNodes\GraphUser $graphUser): \Pd\FacebookLoginApi\FacebookLoginObject
	{
		$facebookUser = new \Pd\FacebookLoginApi\FacebookLoginObject(
			$graphUser->getId(),
			$graphUser->getEmail(),
			$graphUser->getFirstName(),
			$graphUser->getLastName()
		);

		return $facebookUser;
	}
}
