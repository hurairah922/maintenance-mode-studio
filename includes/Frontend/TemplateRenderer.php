<?php
/**
 * Default maintenance template renderer.
 *
 * @package MaintenanceModeStudio
 */

namespace Maneuvrez\MaintenanceModeStudio\Frontend;

use Maneuvrez\MaintenanceModeStudio\Components\ComponentRegistry;
use Maneuvrez\MaintenanceModeStudio\Security\Sanitizer;
use Maneuvrez\MaintenanceModeStudio\Settings\SettingsRepository;
use Maneuvrez\MaintenanceModeStudio\Support\Escaper;

defined( 'ABSPATH' ) || exit;

/**
 * Loads frontend templates through a registry-driven renderer.
 */
class TemplateRenderer {
	/**
	 * Template registry.
	 *
	 * @var TemplateRegistry
	 */
	private $template_registry;

	/**
	 * Component registry.
	 *
	 * @var ComponentRegistry
	 */
	private $component_registry;

	/**
	 * Settings repository.
	 *
	 * @var SettingsRepository
	 */
	private $settings_repository;

	/**
	 * Constructor.
	 *
	 * @param TemplateRegistry|null   $template_registry Template registry.
	 * @param ComponentRegistry|null  $component_registry Component registry.
	 * @param SettingsRepository|null $settings_repository Settings repository.
	 */
	public function __construct( $template_registry = null, $component_registry = null, $settings_repository = null ) {
		$this->template_registry   = $template_registry instanceof TemplateRegistry ? $template_registry : new TemplateRegistry();
		$this->component_registry  = $component_registry instanceof ComponentRegistry ? $component_registry : new ComponentRegistry();
		$this->settings_repository = $settings_repository instanceof SettingsRepository ? $settings_repository : new SettingsRepository();
	}

	/**
	 * Render the selected public template.
	 *
	 * @param array<string,mixed> $settings Sanitized settings.
	 * @return void
	 */
	public function render( array $settings = array() ) {
		if ( empty( $settings ) ) {
			$settings = $this->settings_repository->get_settings();
		}

		$settings = Sanitizer::get_settings( $settings );
		$template = $this->template_registry->resolve( (string) $settings['template_key'] );
		$assets   = $this->enqueue_assets( $template );
		$context  = $this->build_context( $settings, $template, $assets );
		$renderer = $this;

		if ( ! empty( $template['file'] ) && file_exists( $template['file'] ) ) {
			require $template['file'];
			return;
		}

		$this->render_basic_fallback( $context );
	}

	/**
	 * Render a zone using the current template layout.
	 *
	 * @param string              $zone Zone key.
	 * @param array<string,mixed> $settings Normalized settings.
	 * @param array<string,mixed> $context Shared context.
	 * @return string
	 */
	public function render_zone( $zone, array $settings, array $context ) {
		$template = isset( $context['template'] ) && is_array( $context['template'] ) ? $context['template'] : $this->template_registry->resolve( 'default' );
		$zones    = isset( $template['zones'] ) && is_array( $template['zones'] ) ? $template['zones'] : array();

		if ( ! in_array( $zone, $zones, true ) ) {
			return '';
		}

		$layout  = isset( $template['layout'][ $zone ] ) && is_array( $template['layout'][ $zone ] ) ? $template['layout'][ $zone ] : array();
		$outputs = array();

		foreach ( $layout as $component_key ) {
			$markup = $this->component_registry->render( (string) $component_key, $zone, $settings, $context );

			if ( '' === $markup ) {
				continue;
			}

			$outputs[] = $markup;
		}

		return implode( '', $outputs );
	}

	/**
	 * Register and enqueue only the current template assets.
	 *
	 * @param array<string,mixed> $template Template configuration.
	 * @return array<string,array<int,string>>
	 */
	private function enqueue_assets( array $template ) {
		wp_register_style(
			'mmsm-public-template-default',
			MMSM_PLUGIN_URL . 'assets/css/public-template-default.css',
			array(),
			MMSM_VERSION
		);

		wp_register_script(
			'mmsm-public-template-default',
			MMSM_PLUGIN_URL . 'assets/js/public-template-default.js',
			array(),
			MMSM_VERSION,
			false
		);

		wp_script_add_data( 'mmsm-public-template-default', 'defer', true );

		$assets = array(
			'styles'  => array(),
			'scripts' => array(),
		);

		if ( ! empty( $template['assets']['styles'] ) && is_array( $template['assets']['styles'] ) ) {
			foreach ( $template['assets']['styles'] as $style_handle ) {
				wp_enqueue_style( $style_handle );
				$assets['styles'][] = $style_handle;
			}
		}

		if ( ! empty( $template['assets']['scripts'] ) && is_array( $template['assets']['scripts'] ) ) {
			foreach ( $template['assets']['scripts'] as $script_handle ) {
				wp_enqueue_script( $script_handle );
				$assets['scripts'][] = $script_handle;
			}
		}

		return $assets;
	}

	/**
	 * Build the shared template context.
	 *
	 * @param array<string,mixed>              $settings Sanitized settings.
	 * @param array<string,mixed>              $template Resolved template config.
	 * @param array<string,array<int,string>>  $assets Asset handles.
	 * @return array<string,mixed>
	 */
	private function build_context( array $settings, array $template, array $assets ) {
		$theme_variables = $this->get_theme_variables( (string) $settings['theme_mode'], (string) $settings['primary_color'] );

		return array(
			'charset'        => get_bloginfo( 'charset' ),
			'language'       => get_bloginfo( 'language' ),
			'site_name'      => get_bloginfo( 'name' ),
			'document_title' => (string) $settings['page_title'],
			'mode_label'     => 'coming_soon' === $settings['mode_type']
				? __( 'Coming Soon', MMSM_TEXT_DOMAIN )
				: __( 'Maintenance Mode Active', MMSM_TEXT_DOMAIN ),
			'login_url'      => wp_login_url(),
			'shell_class'    => Escaper::classes(
				array(
					'mmsm-shell',
					'mmsm-theme-' . (string) $settings['theme_mode'],
					'mmsm-mode-' . (string) $settings['mode_type'],
				)
			),
			'shell_style'    => Escaper::css_variables( $theme_variables ),
			'assets'         => $assets,
			'template'       => $template,
		);
	}

	/**
	 * Build theme variables for the selected mode.
	 *
	 * @param string $theme_mode Theme mode.
	 * @param string $primary_color Primary color.
	 * @return array<string,string>
	 */
	private function get_theme_variables( $theme_mode, $primary_color ) {
		$primary_color = sanitize_hex_color( $primary_color );

		if ( empty( $primary_color ) ) {
			$primary_color = '#2563eb';
		}

		$themes = array(
			'light'  => array(
				'mm-bg'           => '#eef4ff',
				'mm-surface'      => 'rgba(255,255,255,0.84)',
				'mm-text'         => '#0f1f35',
				'mm-muted'        => '#5e6c82',
				'mm-border'       => 'rgba(37,99,235,0.14)',
				'mm-primary'      => $primary_color,
				'mm-primary-text' => '#ffffff',
				'mm-shadow'       => '0 24px 80px rgba(15,23,42,0.16)',
				'mm-radius'       => '28px',
				'mm-content-width'=> '1120px',
			),
			'dark'   => array(
				'mm-bg'           => '#08111f',
				'mm-surface'      => 'rgba(9,19,33,0.82)',
				'mm-text'         => '#f2f6ff',
				'mm-muted'        => '#aabbd5',
				'mm-border'       => 'rgba(148,163,184,0.22)',
				'mm-primary'      => $primary_color,
				'mm-primary-text' => '#ffffff',
				'mm-shadow'       => '0 24px 80px rgba(0,0,0,0.34)',
				'mm-radius'       => '28px',
				'mm-content-width'=> '1120px',
			),
			'system' => array(
				'mm-bg'           => '#eef4ff',
				'mm-surface'      => 'rgba(255,255,255,0.84)',
				'mm-text'         => '#0f1f35',
				'mm-muted'        => '#5e6c82',
				'mm-border'       => 'rgba(37,99,235,0.14)',
				'mm-primary'      => $primary_color,
				'mm-primary-text' => '#ffffff',
				'mm-shadow'       => '0 24px 80px rgba(15,23,42,0.16)',
				'mm-radius'       => '28px',
				'mm-content-width'=> '1120px',
			),
		);

		if ( ! isset( $themes[ $theme_mode ] ) ) {
			$theme_mode = 'light';
		}

		return $themes[ $theme_mode ];
	}

	/**
	 * Render a minimal fallback page if the template file is unavailable.
	 *
	 * @param array<string,mixed> $context Template context.
	 * @return void
	 */
	private function render_basic_fallback( array $context ) {
		?>
		<!doctype html>
		<html lang="<?php echo esc_attr( $context['language'] ); ?>">
		<head>
			<meta charset="<?php echo esc_attr( $context['charset'] ); ?>" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<title><?php echo esc_html( $context['document_title'] ); ?></title>
		</head>
		<body>
			<main>
				<h1><?php echo esc_html( $context['document_title'] ); ?></h1>
				<p><?php echo esc_html( $context['site_name'] ); ?></p>
			</main>
		</body>
		</html>
		<?php
	}
}
