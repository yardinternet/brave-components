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

1. Install this package with Composer:

    ```sh
    composer require yard/brave-components
    ```

2. Run the Acorn WP-CLI command to discover this package:

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

Shows a back button that determines its link and text by checking the parent page. If the post has no parent, it sets the link to a predefined parent page slug or defaults to "javascript:history.back();".

Usage:

```blade
<x-brave-back-button /> 
<x-brave-back-button text="Terug naar het vacature-overzicht" />
<x-brave-back-button className="custom-class" />
```

### Breadcrumb

Generate a breadcrumb based on the current page. Also adds posts added through the `parent-page` supports feature. Usage:

```blade
<x-brave-breadcrumb listClass="" itemClass="" linkClass="" currentItemClass="" />
```

Or pass your own collection of items to show a custom breadcrumb:

```blade
<x-brave-breadcrumb :items="collect([
    ['id' => null, 'url' => home_url(), 'label' => 'Home'],
    ['id' => null, 'url' => home_url('woo-verzoeken'), 'label' => 'Woo verzoeken'],
])" />
```

### Dialog

Usage:

```blade
<x-brave::dialog.trigger dialogId="my-dialog">
    Open dialog
</x-brave::dialog.trigger>

<x-brave-dialog id="my-dialog" ariaLabel="My dialog">
    <p>This is the content of the dialog.</p>
    
    <x-brave::dialog.trigger dialogId="my-dialog">
        Close dialog
    </x-brave::dialog.trigger>
</x-brave-dialog>
```

### Pattern Content

Shows the content of a pattern by its slug. You can find the slug (post name) using the `wp post get` CLI command and providing the post ID.

Usage:

```blade
<x-brave-pattern-content slug="footer" />
<x-brave-pattern-content slug="single-vacancy-contact-information" />
```

Configure the admin behavior of each pattern in the `components.php` config file to automatically save them as drafts (thus hiding them from the pattern inserter), prevent their deletion, and add custom labels in the admin view.

### Read Speaker

Adds a ReadSpeaker button on specific places with the component and automatically adds it to the content of H1 blocks in the post content. Make sure to configure the `readSpeaker` settings in the `components.php` config file to set your customer ID and other options.

Usage:

```blade
<x-brave-read-speaker />
```

### Nav

Navigation component with optional dropdowns. Provides the right ARIA attributes and keyboard navigation for accessibility.

Dropdown visibility is controlled via `aria-expanded`. Use it in combination with the `group` class on the parent item and `group-has-aria-expanded` variants to show/hide the dropdown.

**Dropdown modes**

- `click` (default) — opens on click
- `hover` - opens on hover, closes when the mouse leaves the item

For accessibility, the `<x-brave::nav>` component requires an `aria-label`.

Example usage with Navi:

```blade
@php($menu = \Log1x\Navi\Navi::make()->build('primary_navigation'))

@if ($menu->isNotEmpty())
    <x-brave::nav aria-label="{{ __('Primaire navigatie', 'sage') }}">
        <x-brave::nav.list>
            @foreach ($menu->all() as $item)
                <x-brave::nav.item class="group">
                    <x-brave::nav.link :item="$item" class="text-blue-500" activeClass="text-red-500">
                        {!! $item->label !!}
                        @if ($item->children)
                            <i class="fa-light fa-chevron-down"></i>
                        @endif
                    </x-brave::nav.link>

                    @if ($item->children)
                        <x-brave::nav.dropdown mode="hover" @class([
                            'invisible absolute bg-white',
                            'group-has-aria-expanded:visible',
                        ])>
                            @foreach ($item->children as $child)
                                <x-brave::nav.item>
                                    <x-brave::nav.link :item="$child" class="text-blue-500" activeClass="text-red-500">
                                        {!! $child->label !!}
                                    </x-brave::nav.link>
                                </x-brave::nav.item>
                            @endforeach
                        </x-brave::nav.dropdown>
                    @endif
                </x-brave::nav.item>
            @endforeach
        </x-brave::nav.list>
    </x-brave::nav>
@endif

```

Usage without Navi:

```blade
<x-brave::nav aria-label="Main navigation">
    <x-brave::nav.list>
        <x-brave::nav.item>
            <x-brave::nav.link href="/contact" :isActive="true" activeClass="text-red-500">
                First item
            </x-brave::nav.link>
        </x-brave::nav.item>

        <x-brave::nav.item class="group">
            <x-brave::nav.link href="#" :hasChildren="true">
                Dropdown
            </x-brave::nav.link>

            {{-- Change mode via mode="hover" --}}
            <x-brave::nav.dropdown mode="hover" @class([
                'invisible absolute bg-white',
                'group-has-aria-expanded:visible',
            ])>
                <x-brave::nav.item>
                    <x-brave::nav.link href="/contact">
                        Dropdown item 1
                    </x-brave::nav.link>
                </x-brave::nav.item>

                <x-brave::nav.item>
                    <x-brave::nav.link href="/">
                        Dropdown item 2
                    </x-brave::nav.link>
                </x-brave::nav.item>
            </x-brave::nav.dropdown>
        </x-brave::nav.item>
    </x-brave::nav.list>
</x-brave::nav>
```

### Tooltip

Usage:

```blade
<x-brave::tooltip.trigger id="my-tooltip-trigger" ariaDescribedby="my-tooltip">
    Hover or focus me
</x-brave::tooltip.trigger>
<x-brave::tooltip id="my-tooltip">
    This is the tooltip content.
</x-brave::tooltip>
```

## About us

[![banner](https://raw.githubusercontent.com/yardinternet/.github/refs/heads/main/profile/assets/small-banner-github.svg)](https://www.yard.nl/werken-bij/)
