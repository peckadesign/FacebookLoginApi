<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class Config
{
	/**
	 * @var array
	 */
	private $permissions;

	/**
	 * @var string
	 */
	private $loginUrlDestination;

	/**
	 * @var array
	 */
	private $fields;


	public function __construct(
		string $loginUrlDestination,
		array $permissions,
		array $fields
	)
	{
		$this->permissions = $permissions;
		$this->loginUrlDestination = $loginUrlDestination;
		$this->fields = $fields;
	}


	public function getPermissions(): array
	{
		return $this->permissions;
	}


	public function getLoginUrlDestination(): string
	{
		return $this->loginUrlDestination;
	}


	public function getFields(): array
	{
		return $this->fields;
	}
}
