<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class Config
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
	 * @var string[]
	 */
	private $fields;


	/**
	 * @param string[] $permissions
	 * @param string[] $fields
	 */
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


	/** @return string[] */
	public function getPermissions(): array
	{
		return $this->permissions;
	}


	public function getLoginUrlDestination(): string
	{
		return $this->loginUrlDestination;
	}


	/** @return string[] */
	public function getFields(): array
	{
		return $this->fields;
	}
}
