<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

interface LinkGeneratorInterface
{

	public function link(string $destination, array $parameters = []): string;

}
