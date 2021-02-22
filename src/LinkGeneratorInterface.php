<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

interface LinkGeneratorInterface
{

	/**
	 * @param array<string, mixed> $parameters
	 */
	public function link(string $destination, array $parameters = []): string;

}
