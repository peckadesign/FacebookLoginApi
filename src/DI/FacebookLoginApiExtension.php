<?php declare(strict_types = 1);

namespace Pd\FacebookLoginApi\DI;

final class FacebookLoginApiExtension extends \Nette\DI\CompilerExtension
{
	public function getConfigSchema(): \Nette\Schema\Schema
	{
		return \Nette\Schema\Expect::structure(
			[
				'appId' => \Nette\Schema\Expect::string(),
				'appSecret' => \Nette\Schema\Expect::string(),
				'defaultGraphVersion' => \Nette\Schema\Expect::string('v3.2'),
				'fbApiResponseDestinationUid' => \Nette\Schema\Expect::string(),
				'persistentDataHandler' => \Nette\Schema\Expect::string('session'),
				'permissions' => \Nette\Schema\Expect::arrayOf(\Nette\Schema\Expect::string())
					->default(['email']),
				'fields' => \Nette\Schema\Expect::arrayOf(\Nette\Schema\Expect::string())
					->default(['id', 'first_name', 'last_name', 'email']),
			]
		)->castTo('array');
	}


	public function loadConfiguration(): void
	{
		parent::loadConfiguration();
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('config'))
			->setFactory(\Pd\FacebookLoginApi\Config::class)
			->setArguments([
				'loginUrlDestination' => $config['fbApiResponseDestinationUid'],
				'permissions' => $config['permissions'],
				'fields' => $config['fields'],
			])
		;

		$builder->addDefinition($this->prefix('facebookLoginRequestFactory'))
			->setFactory(\Pd\FacebookLoginApi\FacebookLoginRequestLinkFactory::class)
		;

		$builder->addDefinition($this->prefix('facebookUserMapper'))
			->setFactory(\Pd\FacebookLoginApi\FacebookUserMapper::class)
		;

		$builder->addDefinition($this->prefix('facebookLoginObjectLoader'))
			->setFactory(\Pd\FacebookLoginApi\FacebookLoginObjectLoader::class)
		;

		$builder->addDefinition($this->prefix('facebook'))
			->setFactory(\Facebook\Facebook::class)
			->setArguments([
				'config' => [
					'app_id' => $config['appId'],
					'app_secret' => $config['appSecret'],
					'default_graph_version' => $config['defaultGraphVersion'],
					'persistentDataHandler' => $config['persistentDataHandler'],
				],
			])
			->setAutowired(FALSE)
		;

		$builder->addDefinition($this->prefix('facebookFactory'))
			->setFactory(\Pd\FacebookLoginApi\Facebook::class)
			->setArguments([
				'facebook' => \sprintf('@%s', $this->prefix('facebook')),
			])
		;

		$builder->addDefinition($this->prefix('facebookLoginReRequestFactory'))
			->setFactory(\Pd\FacebookLoginApi\FacebookLoginReRequestLinkFactory::class)
		;
	}
}
