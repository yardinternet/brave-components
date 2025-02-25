# Brave components

[![Code Style](https://github.com/yardinternet/brave-components/actions/workflows/format-php.yml/badge.svg?no-cache)](https://github.com/yardinternet/brave-components/actions/workflows/format-php.yml)
[![PHPStan](https://github.com/yardinternet/brave-components/actions/workflows/phpstan.yml/badge.svg?no-cache)](https://github.com/yardinternet/brave-components/actions/workflows/phpstan.yml)
[![Tests](https://github.com/yardinternet/brave-components/actions/workflows/run-tests.yml/badge.svg?no-cache)](https://github.com/yardinternet/brave-components/actions/workflows/run-tests.yml)
[![Code Coverage Badge](https://github.com/yardinternet/brave-components/blob/badges/coverage.svg)](https://github.com/yardinternet/brave-components/actions/workflows/badges.yml)
[![Lines of Code Badge](https://github.com/yardinternet/brave-components/blob/badges/lines-of-code.svg)](https://github.com/yardinternet/brave-components/actions/workflows/badges.yml)

Collection of logic-heavy components used in Brave projects.

## Requirements

- [Sage](https://github.com/roots/sage) >= 10.0
- [Acorn](https://github.com/roots/acorn) >= 4.0

## Installation

To install this package using Composer, follow these steps:

1. Add the following to the `repositories` section of your `composer.json`:

    ```json
    {
      "type": "vcs",
      "url": "git@github.com:yardinternet/brave-components.git"
    }
    ```

2. Install this package with Composer:

    ```sh
    composer require yard/brave-components
    ```

3. Run the Acorn WP-CLI command to discover this package:

    ```shell
    wp acorn package:discover
    ```

You can publish the config file with:

```shell
wp acorn vendor:publish --provider="Yard\Brave\ComponentsServiceProvider"
```

To only publish the views, run:

```shell
wp acorn vendor:publish --provider="Yard\Brave\ComponentsServiceProvider" --tag="views"
```

## Components

### Back Button

TODO

### Pattern Content

Shows the content of a pattern by its slug.

Usage:

```blade
<x-brave-pattern-content slug="footer" />
<x-brave-pattern-content slug="single-vacancy-contact-information" />
```

Configure the admin behavior of each pattern in the `components.php` config file to automatically save them as drafts (thus hiding them from the pattern inserter), prevent their deletion, and add custom labels in the admin view.
