# Contactor
A PHP application for your contact management.
- Symfony 5.4
- Initial application with ambition of further development and practical usability
- Made with fun and love

## Features:
- CRUD of contacts data

## Usage (CLI commands):
1. have installed composer and php in your system
2. clone this repository
3. import database (contacts.sql) exposed on port 3366
4. install dependencies: 
    ```sh
    composer install
    yarn install
    ```
5. start symfony server in the background: 
    ```sh
    symfony server:start -d
    ```
6. start encore server 
    ```sh
    yarn watch
    ```

## Modules to install (list of commands)
```sh
composer require annotations
composer require twig
composer require sensio/framework-extra-bundle
composer require symfony/asset
composer require --dev symfony/var-dumper
composer require symfony/orm-pack -W (instalace s dependencies)
composer require --dev symfony/maker-bundle
composer require --dev symfony/profiler-pack
composer require symfony/form
composer require symfony/validator
composer require symfony/ux-twig-component
composer require symfony/webpack-encore-bundle
	yarn install
	yarn encore dev-server
composer require knplabs/knp-paginator-bundle:* -W
and possibly composer require symfony-cmf/routing-bundle:* -W
```

## Routes
- contacts_all:
  path: /
  controller: App\Controller\ContactControllerPhpController::index

- contact_create:
  path: /contact/new
  controller: App\Controller\ContactControllerPhpController::new

- contact_detail:
  path: /contact/{id}
  controller: App\Controller\ContactControllerPhpController::detail

- contact_update:
  path: /contacts/update/{id}
  controller: App\Controller\ContactControllerPhpController::updateFromID

- contact_update_slug:
  path: /{slug}
  controller: App\Controller\ContactControllerPhpController::update

- contact_remove:
  path: /contact/delete/{id}
  controller: App\Controller\ContactControllerPhpController::remove

- contact_search:
  path: /contact/search/{search_string}
  controller: App\Controller\ContactControllerPhpController::search

## Future development
- friendly UI
- contacts images
- advanced filters according to multiple attributes
- browser responsivity and optimization of UI
- dynamic routing by contact name