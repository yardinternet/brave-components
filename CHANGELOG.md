# Changelog

## [1.7.2] - 2026-07-30

-   Change: renamed config keys to snake_case (`feedback_form_id`, `read_speaker.customer_id`, `read_speaker.read_id`, `read_speaker.automatically_add_to_h1`), with backwards-compatible fallback to the old camelCase names
-   Fix: handle null Tolkie token configuration
-   Chore: add release GitHub workflow

## [1.7.1] - 2026-07-22

-   Added: allow breadcrumbs to be filtered

## [1.7.0] - 2026-07-20

-   chore: add Tolkie component and config options
-   Fix: incorrect import for Tolkie component
-   Fix: pattern content heading level attribute default

## [1.6.3] - 2026-07-17

-   Fix: include query params in ReadSpeaker URL

## [1.6.2] - 2026-06-03

-   Fix: type error when `$id` is `false` for `get_permalink` argument

## [1.6.1] - 2026-06-02

-   Added: parent page trait

## [1.6.0] - 2026-05-01

-   Added: fallback to post type slug for parent page in breadcrumbs

## [1.5.0] - 2026-04-20

-   Added: tooltip component

## [1.4.0] - 2026-04-14

-   Added: navigation components with dropdown-on-click and dropdown-on-hover variants
-   Change: renamed `active` prop to `isActive` and added `activeClass` option; nav items with children now render as a button instead of a link
-   Fix: address security finding flagged in pull request review

## [1.3.2] - 2026-04-14

-   Added: breadcrumb ancestors support for custom post types

## [1.3.1] - 2026-04-02

-   Fix: `get_permalink` not working for all pages in ReadSpeaker component

## [1.3.0] - 2026-04-02

-   Added: ReadSpeaker component

## [1.2.1] - 2026-03-13

-   Fix: don't display inactive feedback forms

## [1.2.0] - 2026-02-18

-   Added: breadcrumb component
-   Change: renamed `blogId` parameter to `postId`

## [1.1.2] - 2026-02-17

-   Fix: remove duplicate classes on dialog components

## [1.1.1] - 2026-02-17

-   Added: `data-use-show` attribute for dialog component

## [1.1.0] - 2026-01-29

-   Added: dialog component
-   chore: update to PHP 8.2
-   chore: open-source the package

## [1.0.9] - 2025-10-27

-   chore: dependency updates

## [1.0.8] - 2025-05-27

-   Added: accordion components

## [1.0.7] - 2025-05-13

-   Added: SocialIcon component

## [1.0.6] - 2025-04-16

-   Added: 404 pattern content config option
-   chore: add class directive to back-button component

## [1.0.5] - 2025-04-09

-   Added: feedback form component

## [1.0.4] - 2025-04-08

-   Added: image focal point component with overwritable position and src
-   chore: fix back-button character encoding

## [1.0.3] - 2025-03-14

-   Fix: default align value for back button component

## [1.0.2] - 2025-03-04

-   Fix: include draft post status in query

## [1.0.1] - 2025-02-27

-   Added: back button component
-   Added: pattern slug agnostic support
-   Added: option to make hook optional
-   chore: improve config structure

## [1.0.0] - 2025-02-25

-   Added: initial release
