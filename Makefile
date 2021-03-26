composer:
	composer validate
	composer update --no-interaction --prefer-dist

cs:
	vendor/bin/phpcs src/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandard/ruleset.xml
	vendor/bin/phpcs src/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandardStrict/ruleset.xml

phpstan:
	vendor/bin/phpstan analyse src/ --level 8 -c phpstan.neon --no-progress --error-format github
