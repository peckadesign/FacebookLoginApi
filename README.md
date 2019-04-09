# Facebook Login Api Module

Slouží pro vytvoření odkazu pro přihlášení pomocí Facebooku a načtení uživatelských dat přijatých z Facebooku

## Instalace

### Načtení závislosti
```bash
$ composer require peckadesign/facebook-login-api
```

### Zaregistrování extension

```neon
extensions: 
	facebookLoginApi: Pd\FacebookLoginApi\DI\FacebookLoginApiExtension
```

## Konfigurace
### Neon

```neon
facebookLoginApi:
	appId: XXX
	appSecret: XXXX
	fbApiResponseDestinationUid: ::sprintf('UID|%s', ::constant(\App\Page\Page::UID_FACEBOOK_LOGIN_RESPONSE)) #nebo klasické nettí `:Page:FacebookLogin:`
```

## Implementace
### Vygenerování odkazu v presenteru

```php
<?php declare(strict_types = 1);

final class KdejakyPresenter extends \Nette\Application\UI\Presenter
{
	/**
	 * @var \Pd\FacebookLoginApi\FacebookLoginRequestLinkFactory
	 */
	private $facebookLoginRequestFactory;
	
	public function __construct(
		\Pd\FacebookLoginApi\FacebookLoginRequestLinkFactory $facebookLoginRequestFactory
	)
	{
		parent::__construct();
		$this->facebookLoginRequestFactory = $facebookLoginRequestFactory;
	}
	
	
	public function renderDefault(): void 
	{
		/*
		 * Parametr funkce `createRequest` přijímá state parametr, který je schopen Facebook vrátit. 
		 * Používá se nepříklad pro uložení backlinku.
		 */ 
		$this->template->requestLink = $this->facebookLoginRequestFactory->createRequestLink($this->storeRequest());
	}
}
```

### Zpracování Facebook requestu

Zpracování probíhá na stránce, která se nastavuje `FacebookLoginRequestFactory` v konfigurace, například v neonu.

```php
<?php declare(strict_types = 1);

final class JakykolivPresenter extends \Nette\Application\UI\Presenter
{
	/**
	 * @var \Pd\FacebookLoginApi\FacebookLoginObjectLoader
	 */
	private $facebookLoginObjectLoader;
	
	/**
	 * @var \Pd\FacebookLoginApi\Facebook
	 */
	private $facebook;
	
	public function __construct(
		\Pd\FacebookLoginApi\FacebookLoginObjectLoader $facebookLoginObjectLoader,
		\Pd\FacebookLoginApi\Facebook $facebook
	)
	{
		parent::__construct();
		$this->facebookLoginObjectLoader = $facebookLoginObjectLoader;
		$this->facebook = $facebook;
	}
	
	
	public function renderDefault(): void 
	{
		/** @var \Pd\FacebookLoginApi\FacebookLoginObject $facebookUser */
		$facebookUser = $this->facebookLoginObjectLoader->load();
		
		//zpracování dat načtených z Facebooku
		
		// načtení state parametru
		$storedRequest = $this->facebook->getStoredRequest();
		$this->restoreRequest($storedRequest);
	}
}
```
