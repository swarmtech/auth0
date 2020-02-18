
###
# Composer by PHP Version
###
composer-update: composer-update-php7.4

composer-update-php7.4:
	@docker run --rm -it --volume ${PWD}:/app --volume ${COMPOSER_HOME:-${HOME}/.composer}:/tmp composer:1.9 composer update --ignore-platform-reqs

composer-update-php-5.6:
	@docker run --rm -it -v ${PWD}:/usr/src/app --volume ${COMPOSER_HOME:-${HOME}/.composer}:/tmp graze/composer:php-5.6 update --ignore-platform-reqs

###
# Lint PHP by version
###
lint: lint-php-7.4

lint-php-7.4:
	@docker run --init -it --rm -v ${PWD}:/project -w /project jakzal/phpqa:php7.4-alpine phplint src/

lint-php-5.6:
	@docker run -it --rm -v ${PWD}:/data -w /data/src cytopia/phplint:5.6 *\.php

###
# PHPUnit by PHP Version
###
phpunit: phpunit-php-7.4

phpunit-php-7.4:
	@docker run -itv --rm --volume ${PWD}:/usr/src/myapp -w /usr/src/myapp php:7.4-cli vendor/bin/phpunit

phpunit-php-5.6:
	@docker run -itv --rm --volume ${PWD}:/usr/src/myapp -w /usr/src/myapp php:5.6-cli vendor/bin/phpunit
