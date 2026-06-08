# Maintenance Mode Studio — Phase Roadmap

## Phase 0 — Constitution and Active Spec

Goal: lock product and technical rules before coding.

Deliverables:

- product constitution
- technical constitution
- design constitution
- security constitution
- active feature spec
- initial plugin folder plan

Exit criteria:

- product name approved
- prefix approved
- V1 scope approved
- first build milestone defined

## Phase 1 — Plugin Core Shell

Goal: create a working WordPress plugin foundation.

Build:

- main plugin file
- namespaced loader
- activation/deactivation classes
- constants
- autoload pattern
- admin menu shell
- settings registration
- asset loading foundation
- WordPress.org-ready readme scaffold

Exit criteria:

- plugin activates without fatal errors
- admin menu appears
- settings page loads
- no frontend changes yet unless enabled

## Phase 2 — Mode Manager and Router

Goal: make maintenance/coming soon mode functional.

Build:

- mode enable/disable
- mode type selection
- frontend request interception
- admin bypass
- login page bypass
- REST/AJAX bypass rules
- secret bypass token foundation
- basic default maintenance page

Exit criteria:

- logged-out visitors see maintenance page
- logged-in admins see real site
- bypass rules work safely

## Phase 3 — Template Renderer

Goal: render polished public pages.

Build:

- PHP template renderer
- template registry
- theme variables
- light/dark mode
- responsive shell
- default copy
- asset loading per template

Exit criteria:

- at least one premium frontend template renders cleanly
- page works across desktop, tablet, mobile, small mobile

## Phase 4 — Component Registry

Goal: create reusable frontend/admin components.

Build:

- component registry
- zone compatibility rules
- component settings schema
- hero component
- social links component
- contact reveal component
- login component
- status/progress component

Exit criteria:

- components can be enabled/disabled
- components render from saved settings
- empty states are handled safely

## Phase 5 — Forms and Submissions

Goal: collect visitor input safely.

Build:

- form templates
- custom fields
- REST submission endpoint
- nonce/honeypot/rate limit
- hashed IP tracking
- database table
- admin submissions table
- email notifications
- CSV export

Exit criteria:

- visitors can submit forms
- admin can view submissions
- admin can export CSV
- spam basics are active

## Phase 6 — Reaction Challenge and Leaderboard

Goal: add the first interactive game.

Build:

- Reaction Challenge game module
- progressive difficulty
- scoring rules
- local leaderboard
- admin leaderboard toggle
- admin score view/clear controls
- optional user info capture after game

Exit criteria:

- game works on desktop and mobile
- leaderboard can be enabled/disabled
- score submissions are rate-limited

## Phase 7 — Visual Preview and Drag Zones

Goal: make admin page configuration visual.

Build:

- React admin app
- preview tab
- drag-and-drop zone editor
- component settings panels
- saved layout structure
- simple/advanced mode switching

Exit criteria:

- admin can reorder components in allowed zones
- preview reflects settings
- saved layout renders on frontend

## Phase 8 — Templates, Motion, and Assets

Goal: add visual polish and template variety.

Build:

- Arcade Launch template
- Studio Pause template
- Neon Console template
- Calm Coming Soon template
- pointer-reactive motion
- animation intensity setting
- logo/background/icon upload controls
- optional 3D asset setting if safe

Exit criteria:

- 3+ templates are production-ready
- animations degrade cleanly
- uploaded assets render safely

## Phase 9 — Access Rules and Multi-Experience Support

Goal: support multiple mode-based experiences.

Build:

- multiple experiences
- maintenance experience
- coming soon experience
- launch experience
- private site experience
- active mode assignment
- basic route exclusions

Exit criteria:

- admin can create more than one experience
- admin can choose active mode/experience
- complexity remains manageable

## Phase 10 — QA and WordPress.org Release Prep

Goal: prepare for public release.

Build/check:

- WordPress Coding Standards
- PHPCS
- ESLint
- build output
- readme.txt
- screenshots
- assets licensing
- uninstall cleanup
- translation readiness
- accessibility pass
- responsive testing
- security review

Exit criteria:

- plugin zip builds cleanly
- no critical coding standard issues
- WordPress.org submission package is ready
