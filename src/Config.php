<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi;

final class Config
{

	private string $loginUrlDestination;

	/**
	 * @var string[]
	 */
	private array $permissions;

	/**
	 * @var string[]
	 */
	private array $fields;


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


	public function getLoginUrlDestination(): string
	{
		return $this->loginUrlDestination;
	}


	/** @return string[] */
	public function getPermissions(): array
	{
		return $this->permissions;
	}


	/** @return string[] */
	public function getFields(): array
	{
		return $this->fields;
	}

}
