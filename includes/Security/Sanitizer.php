<?php
/**
 * Input sanitization helpers.
 *
 * @package MaintenanceModeStudio
 */

namespace Maneuvrez\MaintenanceModeStudio\Security;

use Maneuvrez\MaintenanceModeStudio\Settings\SettingsSchema;
use Maneuvrez\MaintenanceModeStudio\Support\Escaper;

defined( 'ABSPATH' ) || exit;

/**
 * Sanitizes plugin settings and request data.
 */
class Sanitizer {
	/**
	 * Default plugin settings.
	 *
	 * @return array<string,int|string>
	 */
	public static function get_default_settings() {
		return SettingsSchema::get_default_settings();
	}

	/**
	 * Read settings and merge them with defaults.
	 *
	 * @param mixed $settings Raw option value.
	 * @return array<string,int|string>
	 */
	public static function get_settings( $settings = null ) {
		if ( ! is_array( $settings ) ) {
			$settings = get_option( MMSM_SETTINGS_OPTION, array() );
		}

		return self::sanitize_settings( wp_parse_args( $settings, self::get_default_settings() ) );
	}

	/**
	 * Sanitize the plugin settings payload.
	 *
	 * @param mixed $input Raw request data.
	 * @return array<string,int|string>
	 */
	public static function sanitize_settings( $input ) {
		$defaults = self::get_default_settings();
		$input    = is_array( $input ) ? $input : array();
		$settings = $defaults;

		$settings['enabled']           = ! empty( $input['enabled'] ) ? 1 : 0;
		$settings['show_progress']     = ! empty( $input['show_progress'] ) ? 1 : 0;
		$settings['show_login_button'] = ! empty( $input['show_login_button'] ) ? 1 : 0;

		$settings['mode_type']    = self::sanitize_choice( $input, 'mode_type', array( 'maintenance', 'coming_soon' ), $defaults );
		$settings['template_key'] = self::sanitize_choice( $input, 'template_key', array( 'default' ), $defaults );
		$settings['theme_mode']   = self::sanitize_choice( $input, 'theme_mode', array( 'light', 'dark', 'system' ), $defaults );

		$settings['page_title']             = self::sanitize_text( $input, 'page_title', $defaults );
		$settings['message']                = self::sanitize_textarea( $input, 'message', $defaults );
		$settings['hero_eyebrow']           = self::sanitize_text( $input, 'hero_eyebrow', $defaults, false );
		$settings['primary_action_label']   = self::sanitize_text( $input, 'primary_action_label', $defaults, false );
		$settings['secondary_action_label'] = self::sanitize_text( $input, 'secondary_action_label', $defaults, false );
		$settings['contact_label']          = self::sanitize_text( $input, 'contact_label', $defaults );
		$settings['contact_message']        = self::sanitize_text( $input, 'contact_message', $defaults );
		$settings['status_label']           = self::sanitize_text( $input, 'status_label', $defaults );
		$settings['login_label']            = self::sanitize_text( $input, 'login_label', $defaults );

		$settings['primary_action_url']   = self::sanitize_url( $input, 'primary_action_url' );
		$settings['secondary_action_url'] = self::sanitize_url( $input, 'secondary_action_url' );
		$settings['social_x_url']         = self::sanitize_url( $input, 'social_x_url' );
		$settings['social_instagram_url'] = self::sanitize_url( $input, 'social_instagram_url' );
		$settings['social_facebook_url']  = self::sanitize_url( $input, 'social_facebook_url' );
		$settings['social_linkedin_url']  = self::sanitize_url( $input, 'social_linkedin_url' );

		$settings['contact_email'] = isset( $input['contact_email'] ) ? sanitize_email( $input['contact_email'] ) : '';
		if ( ! is_email( $settings['contact_email'] ) ) {
			$settings['contact_email'] = '';
		}

		$primary_color = isset( $input['primary_color'] ) ? sanitize_hex_color( $input['primary_color'] ) : '';
		$settings['primary_color'] = empty( $primary_color ) ? $defaults['primary_color'] : $primary_color;

		$progress_value = isset( $input['progress_value'] ) ? (int) $input['progress_value'] : (int) $defaults['progress_value'];
		$settings['progress_value'] = max( 0, min( 100, $progress_value ) );

		return $settings;
	}

	/**
	 * Sanitize a select/choice field.
	 *
	 * @param array<string,mixed> $input Submitted settings.
	 * @param string              $key Field key.
	 * @param array<int,string>   $allowed Allowed values.
	 * @param array<string,mixed> $defaults Default values.
	 * @return string
	 */
	private static function sanitize_choice( array $input, $key, array $allowed, array $defaults ) {
		$value = isset( $input[ $key ] ) ? sanitize_key( $input[ $key ] ) : $defaults[ $key ];

		if ( ! in_array( $value, $allowed, true ) ) {
			return (string) $defaults[ $key ];
		}

		return $value;
	}

	/**
	 * Sanitize a plain text field.
	 *
	 * @param array<string,mixed> $input Submitted settings.
	 * @param string              $key Field key.
	 * @param array<string,mixed> $defaults Default values.
	 * @param bool                $use_default_when_empty Whether to fall back when empty.
	 * @return string
	 */
	private static function sanitize_text( array $input, $key, array $defaults, $use_default_when_empty = true ) {
		$value = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';

		if ( '' === $value && $use_default_when_empty ) {
			return (string) $defaults[ $key ];
		}

		return $value;
	}

	/**
	 * Sanitize a textarea field.
	 *
	 * @param array<string,mixed> $input Submitted settings.
	 * @param string              $key Field key.
	 * @param array<string,mixed> $defaults Default values.
	 * @return string
	 */
	private static function sanitize_textarea( array $input, $key, array $defaults ) {
		$value = isset( $input[ $key ] ) ? sanitize_textarea_field( $input[ $key ] ) : '';

		if ( '' === $value ) {
			return (string) $defaults[ $key ];
		}

		return $value;
	}

	/**
	 * Sanitize a public URL field.
	 *
	 * @param array<string,mixed> $input Submitted settings.
	 * @param string              $key Field key.
	 * @return string
	 */
	private static function sanitize_url( array $input, $key ) {
		if ( ! isset( $input[ $key ] ) ) {
			return '';
		}

		return Escaper::public_url( (string) $input[ $key ] );
	}
}
