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
2. start symfony server in the background: 
    ```sh
    symfony server:start -d
    ```
3. start encore server 
    ```sh
    yarn encore dev-server
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
  controller: App\Controller\ContactControllerPhpController::update

- contact_remove:
  path: /contact/delete/{id}
  controller: App\Controller\ContactControllerPhpController::remove

## Future development
- full ENCORE support: jQuery, Bootstrap
- friendly UI
- images
- filters & search
- browser responsivity and optimization 
- Symfony 6.x support

## Author
SVRL