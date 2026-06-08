# Codex Task: Update Active Spec

## Goal

Update `specs/features/active.md` so it describes the first implementation milestone only.

The active spec should focus on:

    Phase 1 - Plugin Shell

## Project Constants

Plugin:

    Maintenance Mode Studio

Extended title:

    Maintenance Mode Studio - Coming Soon, Games, Forms and Interactive Pages

Publisher:

    Maneuvrez

Publisher domain:

    https://maneuvrez.com

Creator credit:

    Abu Hurarrah

Creator domain:

    https://abuhurarrah.com

Plugin slug:

    maintenance-mode-studio

Prefix:

    mmsm_

PHP namespace:

    Maneuvrez\MaintenanceModeStudio

Text domain:

    maintenance-mode-studio

REST namespace:

    mmsm/v1

## Required Docs To Follow

Read these first:

    docs/constitution/product.md
    docs/constitution/technical.md
    docs/constitution/design.md
    docs/constitution/security.md
    docs/roadmap/phases.md
    specs/features/active.md

## Required Active Spec Sections

Update `specs/features/active.md` with these sections:

- Objective
- Scope
- Files to create
- Files not to touch
- Acceptance criteria
- Security rules
- Testing checklist
- Done criteria
- Out of scope
- Implementation notes

## Scope Rules

Include only the first implementation milestone.

Include:

- Plugin bootstrap
- Activation hook
- Deactivation hook
- Admin page placeholder
- Basic maintenance mode setting
- Basic frontend maintenance router
- Basic default public template
- Safe admin bypass
- Login page bypass
- REST, AJAX, cron, and CLI bypass

Do not include:

- Games
- Forms
- Surveys
- Drag-and-drop zones
- Visual builder
- Leaderboard
- Secret bypass links
- Custom CSS editor
- Custom JS editor
- Pro features
- Payment or license systems

## Acceptance Criteria

The updated active spec must make it clear that:

- The plugin activates without fatal errors.
- The plugin deactivates cleanly.
- The admin page loads.
- A basic setting can be saved.
- Logged-in admins are not blocked.
- Logged-out visitors see the default maintenance page when enabled.
- `wp-login.php` remains accessible.
- REST requests are not blocked.
- AJAX requests are not blocked.
- WP-Cron is not blocked.
- WP-CLI is not blocked.
- All public output must be escaped.
- All saved input must be sanitized.
- Admin settings must use nonce checks.
- Admin actions must use capability checks.
- Text strings must be translation-ready.

## After Completion

Do not move the active spec into `specs/features/done/` yet.

Only update the active spec.
