# Active Feature Spec

## Feature

Template and Component Registry

## Phase

Phase 3

## Goal

Render polished public maintenance pages and define reusable frontend building blocks.

This phase moves the plugin from a basic settings-driven maintenance screen into a flexible frontend system.

The public page should render through templates, components, saved settings, safe defaults, and responsive layout rules.

## Build Scope

Phase 3 includes the following work:

* PHP template renderer
* Template registry
* Component registry
* Zone compatibility rules
* Theme variables
* Light and dark mode support
* Responsive public shell
* Default copy
* Asset loading per template
* Component settings schema
* Hero component
* Social links component
* Contact reveal component
* Login component
* Status/progress component

## Exit Criteria

Phase 3 is complete when:

* At least one polished template renders cleanly
* The public page works across desktop, tablet, mobile, and small mobile
* Components render from saved settings
* Empty states are handled safely
* Templates only load their required assets
* Components do not break the page when settings are missing
* Public output is escaped safely
* Admin settings remain simple and understandable

## Non-Goals

Phase 3 does not include:

* Drag-and-drop page builder
* Advanced animation system
* Multiple complex templates
* Email capture backend
* Analytics dashboard
* Third-party integrations
* Block editor integration
* Custom CSS editor
* Import/export system

## Current Assumptions

The plugin already has:

* A working plugin shell
* A basic maintenance mode router
* Public maintenance mode rendering
* Admin settings persistence
* Basic page title and message settings
* Theme mode and color controls
* Login button setting
* Asset loading foundation

If any of these are missing, Phase 3 should preserve the current working behavior and add only the minimum structure needed to continue safely.

## Recommended Directory Structure

Use this structure as the canonical Phase 3 target:

```text
maintenance-mode/
├── maintenance-mode.php
├── assets/
│   ├── css/
│   │   └── public-template-default.css
│   └── js/
│       └── public-template-default.js
├── includes/
│   ├── Admin/
│   │   └── Admin.php
│   ├── Components/
│   │   ├── ComponentInterface.php
│   │   ├── ComponentRegistry.php
│   │   ├── ContactRevealComponent.php
│   │   ├── HeroComponent.php
│   │   ├── LoginComponent.php
│   │   ├── SocialLinksComponent.php
│   │   └── StatusProgressComponent.php
│   ├── Frontend/
│   │   ├── MaintenanceRouter.php
│   │   ├── TemplateRenderer.php
│   │   └── TemplateRegistry.php
│   ├── Settings/
│   │   ├── SettingsRepository.php
│   │   └── SettingsSchema.php
│   └── Support/
│       └── Escaper.php
├── templates/
│   └── public/
│       └── default.php
├── specs/
│   ├── features/
│   │   └── active.md
│   └── prompts/
│       └── codex/
│           ├── 003-template-component-registry-execution.md
│           └── 003-template-component-registry-review.md
└── README.md
```

## Architecture Overview

Phase 3 should introduce a clean separation between:

* The router that decides when to show maintenance mode
* The template renderer that renders the selected public template
* The template registry that defines available templates
* The component registry that defines available components
* Component classes that render reusable sections
* Settings schema that defines safe defaults and allowed values
* Assets that load only when the selected template needs them

The public page should not contain hardcoded business logic.

The template should receive normalized settings and render registered components.

## Template Renderer

Create a PHP template renderer responsible for rendering public templates.

The renderer should:

* Accept the selected template key
* Resolve the template from the template registry
* Load normalized settings
* Pass settings into the template
* Render components through the component registry
* Escape output safely
* Fall back to the default template if the selected template is missing
* Avoid fatal errors when templates or components are unavailable

The renderer should not:

* Directly read raw `$_POST`, `$_GET`, or `$_REQUEST`
* Save settings
* Register admin fields
* Contain component-specific business logic
* Echo unsafe values

## Template Registry

Create a template registry that defines available public templates.

Each template should include:

* Template key
* Template name
* Template description
* Template file path
* Supported zones
* Required frontend assets
* Default component layout

The first template should be:

```text
default
```

Suggested template metadata:

```php
[
    'key' => 'default',
    'name' => 'Default',
    'description' => 'A polished maintenance mode page with hero, status, contact, social, and login sections.',
    'file' => 'templates/public/default.php',
    'zones' => [
        'main',
        'footer',
    ],
    'assets' => [
        'styles' => [
            'public-template-default',
        ],
        'scripts' => [
            'public-template-default',
        ],
    ],
]
```

## Component Registry

Create a component registry that defines reusable frontend components.

The registry should support:

* Registering components by key
* Checking whether a component exists
* Getting component metadata
* Rendering a component safely
* Returning available components
* Enforcing zone compatibility

The first registered components should be:

* Hero
* Social links
* Contact reveal
* Login
* Status/progress

## Component Interface

Each component should follow a shared interface.

The interface should support:

* Getting the component key
* Getting the component label
* Getting supported zones
* Getting settings schema
* Rendering output from normalized settings

Suggested interface behavior:

```php
interface ComponentInterface
{
    public function get_key(): string;

    public function get_label(): string;

    public function get_supported_zones(): array;

    public function get_settings_schema(): array;

    public function render(array $settings = []): string;
}
```

## Zone Compatibility Rules

Templates should define zones.

Components should define which zones they can render inside.

Initial zones:

```text
main
footer
```

Suggested compatibility:

| Component       | Main Zone | Footer Zone |
| --------------- | --------: | ----------: |
| Hero            |       Yes |          No |
| Status/progress |       Yes |          No |
| Contact reveal  |       Yes |         Yes |
| Social links    |        No |         Yes |
| Login           |        No |         Yes |

If a component is assigned to an incompatible zone, the renderer should skip it safely.

It should not throw a fatal error.

## Theme Variables

The public template should use CSS variables for theme control.

Required variables:

```css
--mm-bg;
--mm-surface;
--mm-text;
--mm-muted;
--mm-border;
--mm-primary;
--mm-primary-text;
--mm-shadow;
--mm-radius;
--mm-content-width;
```

The renderer should expose theme settings as safe class names and CSS variables.

Do not output untrusted CSS without validation.

## Light and Dark Mode

Support these theme modes:

```text
light
dark
system
```

Expected behavior:

* `light` forces the light theme
* `dark` forces the dark theme
* `system` follows the user device preference with `prefers-color-scheme`

The frontend should avoid flashing broken colors.

The default should be:

```text
system
```

## Responsive Shell

The default template should render cleanly on:

* Desktop
* Tablet
* Mobile
* Small mobile

The shell should include:

* Centered page layout
* Safe spacing
* Readable text sizes
* Flexible component stack
* No horizontal overflow
* Touch-friendly buttons
* Safe empty states

Suggested responsive breakpoints:

```css
@media (max-width: 960px) {}
@media (max-width: 640px) {}
@media (max-width: 420px) {}
```

## Default Copy

Use safe defaults when settings are empty.

Default title:

```text
We'll be back soon
```

Default message:

```text
Our site is getting a quick update. Please check back shortly.
```

Default status label:

```text
Maintenance in progress
```

Default progress value:

```text
65
```

Default contact label:

```text
Need help?
```

Default contact text:

```text
Contact us for urgent requests.
```

Default login label:

```text
Admin login
```

## Asset Loading Per Template

Template assets should load only when maintenance mode is active and the matching template is being rendered.

Do not load public template assets across the whole WordPress site.

The asset loading layer should:

* Register template styles
* Register template scripts
* Enqueue only selected template assets
* Use versioning based on plugin version or file modification time
* Avoid duplicate enqueues

## Component Settings Schema

Each component should declare its own settings schema.

The schema should define:

* Setting key
* Label
* Type
* Default value
* Sanitization expectation
* Whether the field is required
* Allowed values, when applicable

Suggested field types:

```text
text
textarea
url
email
boolean
number
select
repeater
```

Phase 3 does not need a complete dynamic admin UI for every component setting.

However, the frontend renderer should be ready to consume saved component settings safely.

## Hero Component

The hero component should render:

* Eyebrow text, optional
* Title
* Message
* Primary action, optional
* Secondary action, optional

Required safety behavior:

* If title is empty, use default title
* If message is empty, use default message
* If action URL is empty, do not render that action
* Escape all text and URLs

## Social Links Component

The social links component should render a list of social links.

Supported fields:

* Label
* URL

Required safety behavior:

* Skip empty URLs
* Skip invalid URLs
* Escape labels
* Render nothing if no valid links exist

Initial supported social labels may include:

* Facebook
* Instagram
* LinkedIn
* X
* YouTube
* GitHub

Do not hardcode fake social URLs.

## Contact Reveal Component

The contact reveal component should render a simple contact section.

Supported fields:

* Contact label
* Contact message
* Email address, optional

Required safety behavior:

* If email is empty, show only the contact message
* If email exists, render it as a safe `mailto:` link
* Do not expose broken or invalid email links

## Login Component

The login component should render a WordPress login link when enabled.

Supported fields:

* Enabled
* Label

Required safety behavior:

* If disabled, render nothing
* If label is empty, use default login label
* Use the WordPress login URL
* Escape the URL and label

## Status/Progress Component

The status/progress component should render maintenance status.

Supported fields:

* Status label
* Progress value
* Show progress

Required safety behavior:

* Clamp progress between `0` and `100`
* If progress is missing, use the default value
* If show progress is false, show only the status label
* Do not render invalid progress attributes

## Empty State Handling

The public page should not break when:

* A title is missing
* A message is missing
* A component setting is missing
* A component has no valid content
* A template key is invalid
* A component key is invalid
* A zone has no components
* A saved option contains an unexpected type

Fallback behavior should be quiet and safe.

Do not expose PHP notices, warnings, or raw errors on the frontend.

## Security Requirements

All public output must be escaped.

Use WordPress escaping helpers where appropriate:

* `esc_html()`
* `esc_attr()`
* `esc_url()`
* `wp_kses_post()`

Sanitize saved settings before use.

Do not trust values loaded from options.

Do not render raw HTML from settings unless explicitly sanitized with an approved allowlist.

## Accessibility Requirements

The public template should include:

* Semantic HTML
* Clear heading hierarchy
* Readable contrast
* Keyboard-accessible links and buttons
* Visible focus states
* Proper progress semantics when progress is shown

The status/progress component should use accessible progress markup.

Suggested markup:

```html
<progress value="65" max="100">65%</progress>
```

## Performance Requirements

The public template should:

* Load only required assets
* Avoid heavy JavaScript
* Work without JavaScript for core content
* Keep CSS scoped to maintenance mode markup
* Avoid layout shifts where possible

## QA Checklist

Before Phase 3 is considered complete, confirm:

* The default template renders with no saved settings
* The default template renders with saved settings
* Invalid template keys fall back safely
* Invalid component keys are skipped safely
* Empty component settings do not create broken markup
* Light mode works
* Dark mode works
* System mode works
* Desktop layout works
* Tablet layout works
* Mobile layout works
* Small mobile layout works
* Public assets load only on the maintenance page
* Admin users can still access the site normally when expected
* Login link works when enabled
* Login link is hidden when disabled
* Progress value is clamped between `0` and `100`
* Social links skip invalid URLs
* Contact email skips invalid email values

## Definition of Done

Phase 3 is done when the plugin has a polished default public template powered by registries, reusable components, safe settings, responsive styling, and predictable empty-state handling.

The system should be simple enough to extend in later phases without rewriting the frontend architecture.
