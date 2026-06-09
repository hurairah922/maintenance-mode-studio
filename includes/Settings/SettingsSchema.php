<?php
/**
 * Settings schema for persisted plugin options.
 *
 * @package MaintenanceModeStudio
 */

namespace Maneuvrez\MaintenanceModeStudio\Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Defines the persisted settings fields and defaults.
 */
class SettingsSchema {
	/**
	 * Return all persisted settings fields.
	 *
	 * @return array<string,array<string,mixed>>
	 */
	public static function get_fields() {
		return array(
			'enabled'                => array(
				'type'    => 'checkbox',
				'default' => 0,
			),
			'mode_type'              => array(
				'type'    => 'select',
				'default' => 'maintenance',
				'choices' => array( 'maintenance', 'coming_soon' ),
			),
			'template_key'           => array(
				'type'    => 'select',
				'default' => 'default',
				'choices' => array( 'default' ),
			),
			'page_title'             => array(
				'type'    => 'text',
				'default' => "We'll be back soon",
			),
			'message'                => array(
				'type'    => 'textarea',
				'default' => 'Our site is getting a quick update. Please check back shortly.',
			),
			'hero_eyebrow'           => array(
				'type'    => 'text',
				'default' => '',
			),
			'primary_action_label'   => array(
				'type'    => 'text',
				'default' => '',
			),
			'primary_action_url'     => array(
				'type'    => 'url',
				'default' => '',
			),
			'secondary_action_label' => array(
				'type'    => 'text',
				'default' => '',
			),
			'secondary_action_url'   => array(
				'type'    => 'url',
				'default' => '',
			),
			'theme_mode'             => array(
				'type'    => 'select',
				'default' => 'light',
				'choices' => array( 'light', 'dark', 'system' ),
			),
			'primary_color'          => array(
				'type'    => 'color',
				'default' => '#2563eb',
			),
			'contact_label'          => array(
				'type'    => 'text',
				'default' => 'Need help?',
			),
			'contact_message'        => array(
				'type'    => 'text',
				'default' => 'Contact us for urgent requests.',
			),
			'contact_email'          => array(
				'type'    => 'email',
				'default' => '',
			),
			'status_label'           => array(
				'type'    => 'text',
				'default' => 'Maintenance in progress',
			),
			'show_progress'          => array(
				'type'    => 'checkbox',
				'default' => 1,
			),
			'progress_value'         => array(
				'type'    => 'number',
				'default' => 65,
				'min'     => 0,
				'max'     => 100,
			),
			'show_login_button'      => array(
				'type'    => 'checkbox',
				'default' => 1,
			),
			'login_label'            => array(
				'type'    => 'text',
				'default' => 'Admin login',
			),
			'social_x_url'           => array(
				'type'    => 'url',
				'default' => '',
			),
			'social_instagram_url'   => array(
				'type'    => 'url',
				'default' => '',
			),
			'social_facebook_url'    => array(
				'type'    => 'url',
				'default' => '',
			),
			'social_linkedin_url'    => array(
				'type'    => 'url',
				'default' => '',
			),
		);
	}

	/**
	 * Return default settings.
	 *
	 * @return array<string,mixed>
	 */
	public static function get_default_settings() {
		$defaults = array();

		foreach ( self::get_fields() as $key => $field ) {
			$defaults[ $key ] = $field['default'];
		}

		return $defaults;
	}
}
