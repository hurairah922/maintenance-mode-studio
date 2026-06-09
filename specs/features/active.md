## Phase 3 Fix: Safe Social Defaults and Tab Save Protection

Phase 3 must fix the remaining social links and tab-saving issues without breaking existing plugin behavior.

The fix must be backward-compatible.

No saved data should be lost during this change.

## Default Social Link Item

The Social Links tab should show one social media item by default when no social links have been saved yet.

This default item should make the UI clear and usable.

Default item:

```php id="kf8d9a"
[
    'platform' => 'facebook',
    'url' => '',
    'custom_name' => '',
    'custom_icon_id' => 0,
    'open_new_tab' => true,
]
```

Expected behavior:

* If no social links exist, show one editable social item
* The default item should not render publicly until it has a valid URL
* The user can change the platform
* The user can enter a URL or email value
* The user can click `Add more` to add another social item
* The user can remove any social item
* If all items are removed, the admin UI should still allow adding a new item
* Empty default rows should not render on the frontend
* Empty default rows should not create broken links

The frontend should only render valid saved social items.

## Add More Social Flow

The Social Links tab should support this flow:

```text id="tkd54e"
1. Open Social Links tab
2. See one social item by default
3. Choose a platform from the dropdown
4. Enter the URL or email value
5. Click Add more to add another social item
6. Choose another platform
7. Enter another URL or email value
8. Remove any item when needed
9. Save settings
```

Known platforms should ask only for:

* Platform
* URL or email value
* Optional open in new tab setting

Known platforms should not ask for a manual label.

The visible label should come from the platform.

## Custom Social Platform With SVG Icon

The custom platform flow should support a custom SVG icon upload.

When the selected platform is `custom`, show:

* Custom platform name
* URL
* Custom icon upload
* Optional open in new tab setting

The custom icon upload should support SVG, but only with safe handling.

SVG security rules:

* Store the uploaded icon as a WordPress attachment ID
* Do not store raw SVG markup in plugin options
* Do not render raw SVG from settings
* Do not allow pasted SVG code
* Do not allow pasted HTML
* Validate that the attachment is an allowed image/icon type
* Escape the resolved attachment URL before output
* Render the uploaded SVG as an image URL, not inline markup
* Use safe alt text from the custom platform name
* Fall back to `Link` if the custom platform name is empty
* Fall back to the generic link icon if the uploaded icon is missing or invalid

Allowed custom icon file types:

```text id="yikgf1"
svg
png
jpg
jpeg
webp
```

Important:

SVG upload support must not weaken plugin security.

If safe SVG upload support is not already available, the implementation should either:

* Use WordPress media library attachment IDs and render SVG only as an escaped image URL
* Or postpone SVG upload support and allow only png, jpg, jpeg, and webp until safe SVG sanitization is available

Do not add unsafe SVG handling just to satisfy the upload field.

## Social Item Removal Rules

Users must be able to remove social media items.

Removal behavior:

* Each repeater item should have a clear remove button
* Removing an item should remove it from the saved settings after save
* Removing one item should not remove unrelated settings
* Removing all social items should save an empty social links array
* After saving an empty social links array, the admin UI may show one blank default item again for convenience
* The frontend should render no social links when there are no valid saved social URLs

Do not force a public social link to exist.

The default row is for admin usability only.

## Tab Save Data Protection

Saving settings in one tab must not erase settings from other tabs.

Current issue:

```text id="pi3zqv"
When saving items for one tab, other tab items are saved as null.
```

This must be fixed before Phase 3 is considered stable.

Expected behavior:

* Saving the General tab preserves Template tab settings
* Saving the General tab preserves Design tab settings
* Saving the General tab preserves Components tab settings
* Saving the General tab preserves Social Links tab settings
* Saving the Social Links tab preserves General tab settings
* Saving the Social Links tab preserves Design tab settings
* Saving any tab only updates fields submitted by that tab
* Missing tab fields must not be interpreted as null values
* Missing tab fields must not overwrite existing saved values

## Safe Settings Merge Strategy

The settings save handler must merge submitted tab values into the existing settings array.

Required save strategy:

```text id="fl3msu"
1. Load existing saved settings.
2. Load default settings schema.
3. Read only submitted fields for the active tab.
4. Sanitize submitted fields.
5. Merge sanitized submitted fields over existing saved settings.
6. Preserve all settings not submitted by the current tab.
7. Save the merged settings array.
```

Do not replace the entire options array with only the submitted tab values.

Do not set missing keys to null.

Do not clear nested arrays unless the active tab intentionally submits an empty array for that setting.

## Nested Settings Merge Rules

Nested settings need special care.

For nested arrays:

* Preserve existing nested keys when they are not submitted
* Update only submitted nested keys
* Save intentional empty arrays only for fields that belong to the active tab
* Do not recursively replace unrelated tab groups with null
* Do not delete unrelated component settings when saving social links
* Do not delete social links when saving design colors

Example:

If the user saves only the Design tab, the save handler may update:

```text id="pgn35o"
theme_mode
colors
```

It must preserve:

```text id="rx7s9m"
mode_type
page_title
page_message
template_key
components
social_links
login_enabled
```

If the user saves only the Social Links tab, the save handler may update:

```text id="qp1jcr"
social_links
```

It must preserve:

```text id="dvsccd"
mode_type
page_title
page_message
template_key
theme_mode
colors
components
login_enabled
```

## Data Loss Prevention Requirements

Before saving settings:

* Existing settings must be loaded
* Defaults must be available
* Submitted values must be sanitized
* Missing values must be ignored unless they belong to the active tab
* The final saved settings must include all required keys
* The final saved settings must not contain unexpected null values

After saving settings:

* Previously saved values from other tabs must remain available
* Public rendering must continue to work
* Admin fields must remain populated
* No tab should appear reset unless the user intentionally changed it

## Updated Phase 3 Exit Criteria

Phase 3 is complete when:

* One default social item appears in the admin when no social links exist
* Empty default social rows do not render publicly
* Users can add more social items
* Users can remove social items
* Known platforms ask only for platform and URL/email value
* Custom platforms support custom name and custom icon upload
* SVG custom icons are handled safely
* Social icons stay aligned and fully visible
* Saving one tab does not erase or null values from other tabs
* Missing submitted fields do not overwrite existing settings
* Nested settings are merged safely
* No saved user data is lost during normal tab saves
