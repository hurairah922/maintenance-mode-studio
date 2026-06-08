# Active Feature Spec — Maintenance Mode Studio Phase 1

## 1. Objective

Build the first working implementation milestone for Maintenance Mode Studio.

Phase 1 must produce a real WordPress plugin that:

- activates safely
- deactivates cleanly
- shows an admin page placeholder
- saves one basic maintenance mode setting securely
- bypasses logged-in administrators
- keeps `wp-login.php`, REST, AJAX, cron, and WP-CLI accessible
- renders a default maintenance page for logged-out visitors when enabled

## 2. Scope

This spec covers Phase 1 only:

- plugin bootstrap
- plugin constants
- namespaced loader
- activation hook
- deactivation hook
- text domain loading
- admin page placeholder
- basic maintenance mode setting
- basic frontend maintenance router
- basic default public template
- scoped frontend CSS and JS foundation
- safe bypass rules for admin, login, REST, AJAX, cron, and WP-CLI

## 3. Files To Create

Create only these Phase 1 files:

```text
maintenance-mode-studio/
├── maintenance-mode-studio.php
├── readme.txt
├── uninstall.php
├── composer.json
├── package.json
├── phpcs.xml.dist
├── includes/
│   ├── Admin/
│   │   └── Admin.php
│   ├── Frontend/
│   │   ├── MaintenanceRouter.php
│   │   └── TemplateRenderer.php
│   ├── Security/
│   │   └── Sanitizer.php
│   ├── Activator.php
│   ├── Deactivator.php
│   └── Plugin.php
├── public/
│   ├── templates/
│   │   └── default.php
│   └── assets/
│       ├── public.css
│       └── public.js
├── src/
│   └── admin/
│       ├── index.js
│       └── index.scss
├── build/
├── languages/
│   ├── maintenance-mode-studio.pot
│   ├── maintenance-mode-studio-fr_FR.po
│   └── maintenance-mode-studio-fr_FR.mo

```

## 4. Files Not To Touch

Do not introduce Phase 2+ feature files yet.

Do not create:

- forms modules
- games modules
- leaderboard modules
- bypass token modules
- custom CSS editor files
- custom JS editor files
- uploads handling files
- Pro or payments files

## 5. Acceptance Criteria

Phase 1 is acceptable when:

- the plugin appears in WordPress admin
- the plugin activates without fatal errors
- the plugin deactivates without fatal errors
- the admin page loads for authorized users
- the maintenance mode setting can be saved
- logged-in administrators are not blocked
- logged-out visitors see the default maintenance page only when the mode is enabled
- `wp-login.php` remains accessible
- REST requests are not blocked
- AJAX requests are not blocked
- WP-Cron is not blocked
- WP-CLI is not blocked
- all visible strings are translation-ready
- all public output is escaped
- all saved input is sanitized

## 6. Security Rules

The milestone must include:

- `defined( 'ABSPATH' ) || exit;` in every PHP file
- capability checks for admin pages and settings actions
- nonce checks for settings actions
- sanitized settings before save
- escaped output at render time
- no raw user input in templates
- no public forms yet
- no uploads yet
- no custom JS yet

## 7. Testing Checklist

Verify:

- plugin activation
- plugin deactivation
- admin page load
- settings save and reload
- logged-out frontend behavior when disabled
- logged-out frontend behavior when enabled
- administrator bypass behavior
- login page accessibility
- REST request accessibility
- AJAX request accessibility
- cron request accessibility
- WP-CLI safety
- responsive frontend rendering

## 8. Done Criteria

This phase is done when:

- all acceptance criteria pass
- the directory structure matches this spec
- the plugin shell is stable on frontend and admin
- no out-of-scope features were added early

## 9. Out Of Scope

Do not implement in Phase 1:

- drag-and-drop zones
- visual preview builder
- forms
- surveys
- CSV export
- Reaction Challenge
- leaderboard
- secret bypass links
- custom CSS editor
- custom JS editor
- uploaded 3D assets
- multiple experiences
- WooCommerce-specific controls
- payments or license systems

## 10. Implementation Notes

Use these locked project constants:

```text
Name: Maintenance Mode Studio
Extended title: Maintenance Mode Studio - Coming Soon, Games, Forms and Interactive Pages
Publisher: Abu Hurarrah
Creator credit: Abu Hurarrah
Creator domain: https://abuhurarrah.com
Contact email: hello@abuhurarrah.com
Slug: maintenance-mode-studio
Prefix: mmsm_
Namespace: Maneuvrez\MaintenanceModeStudio
Text domain: maintenance-mode-studio
REST namespace: mmsm/v1
```

Phase 1 should stay intentionally small. The goal is a dependable plugin shell with a minimal maintenance-mode flow, not a full builder or full V1 feature set.
