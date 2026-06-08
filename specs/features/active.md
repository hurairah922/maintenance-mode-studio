# specs/features/active.md

# Active Feature Spec — Maintenance Mode Studio MVP Foundation

## 1. Objective

Build the first working foundation of Maintenance Mode Studio.

The first milestone must produce a real WordPress plugin that can:

- activate safely
- show an admin settings page
- enable/disable maintenance mode
- bypass logged-in administrators
- render a polished default maintenance page for logged-out visitors
- use the approved product prefix, namespace, text domain, and folder structure

## 2. Locked Product Decisions

```text
Name: Maintenance Mode Studio
Extended title: Maintenance Mode Studio — Coming Soon, Games, Forms & Interactive Pages
Publisher: Maneuvrez
Creator credit: Abu Hurairah / Shafi
Slug: maintenance-mode-studio
Prefix: mmsm_
Namespace: Maneuvrez\MaintenanceModeStudio
Text domain: maintenance-mode-studio
REST namespace: mmsm/v1
Admin stack: React with @wordpress/scripts
Frontend stack: PHP templates + vanilla JS modules
Builder: drag-and-drop zones + preview
First game: Reaction Challenge
Spam V1: honeypot + nonce + rate limit + hashed IP
Captcha: optional later integration
Secret bypass links: yes
WooCommerce: safe compatibility only in V1
Multisite: basic compatibility only, no network dashboard in V1
```

## 3. First Coding Milestone

### Milestone Name

Plugin Core Shell + Basic Maintenance Renderer

### Required Features

1. Main plugin bootstrap file.
2. Plugin constants.
3. Namespaced core loader.
4. Activation/deactivation classes.
5. Admin settings page.
6. Maintenance mode setting.
7. Mode type setting.
8. Frontend maintenance router.
9. Logged-in administrator bypass.
10. Login page bypass.
11. REST/AJAX bypass.
12. Basic public template.
13. Scoped frontend CSS.
14. Scoped frontend JS foundation.
15. Translation-ready strings.
16. Security comments on important flows.

## 4. Initial Admin Settings

V1 foundation settings:

```text
Enable Maintenance Mode: boolean
Mode Type: maintenance | coming_soon | launch | private
Page Title: string
Page Message: textarea
Theme Mode: dark | light
Primary Color: color
Accent Color: color
Show Login Button: boolean
```

## 5. Initial Frontend Page

The default page must include:

- logo placeholder or site name
- status badge
- title
- message
- simple interactive visual object
- login button if enabled
- footer credit hidden/controlled later

The frontend must be responsive from 320px to widescreen.

## 6. Initial File Structure

```text
maintenance-mode-studio/
├── maintenance-mode-studio.php
├── readme.txt
├── package.json
├── composer.json
├── phpcs.xml.dist
├── uninstall.php
├── includes/
│   ├── Plugin.php
│   ├── Activator.php
│   ├── Deactivator.php
│   ├── Settings.php
│   ├── Admin.php
│   ├── MaintenanceRouter.php
│   ├── TemplateRenderer.php
│   ├── AssetManager.php
│   └── Security/
│       └── Sanitizer.php
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
└── languages/
```

## 7. Security Requirements

The milestone must include:

- `defined( 'ABSPATH' ) || exit;` in PHP files
- capability checks for settings
- nonce checks for settings forms
- sanitized settings
- escaped frontend output
- no raw user input output
- no custom JS yet
- no uploads yet
- no public forms yet

## 8. Done Criteria

The milestone is done when:

- plugin activates
- plugin does not fatal on frontend/admin
- admin can enable maintenance mode
- logged-out visitor sees the maintenance page
- logged-in administrator sees real site
- login page remains accessible
- REST requests are not blocked
- settings persist
- frontend page is responsive
- basic coding standard structure is in place

## 9. Not Included Yet

These are intentionally excluded from the first coding milestone:

- drag-and-drop builder
- React preview app
- form submissions
- CSV export
- Reaction Challenge
- leaderboard
- bypass links
- custom CSS
- custom JS
- uploaded 3D assets
- multiple experiences
- WooCommerce-specific controls
