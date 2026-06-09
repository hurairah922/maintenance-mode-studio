<?php
/**
 * Social links component.
 *
 * @package MaintenanceModeStudio
 */

namespace Maneuvrez\MaintenanceModeStudio\Components;

use Maneuvrez\MaintenanceModeStudio\Support\Escaper;

defined( 'ABSPATH' ) || exit;

/**
 * Renders a list of valid social links.
 */
class SocialLinksComponent implements ComponentInterface {
	/**
	 * {@inheritDoc}
	 */
	public function get_key() {
		return 'social_links';
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_label() {
		return __( 'Social links', MMSM_TEXT_DOMAIN );
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_supported_zones() {
		return array( 'footer' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_settings_schema() {
		return array(
			array(
				'key'      => 'social_x_url',
				'label'    => __( 'X URL', MMSM_TEXT_DOMAIN ),
				'type'     => 'url',
				'default'  => '',
				'required' => false,
			),
			array(
				'key'      => 'social_instagram_url',
				'label'    => __( 'Instagram URL', MMSM_TEXT_DOMAIN ),
				'type'     => 'url',
				'default'  => '',
				'required' => false,
			),
			array(
				'key'      => 'social_facebook_url',
				'label'    => __( 'Facebook URL', MMSM_TEXT_DOMAIN ),
				'type'     => 'url',
				'default'  => '',
				'required' => false,
			),
			array(
				'key'      => 'social_linkedin_url',
				'label'    => __( 'LinkedIn URL', MMSM_TEXT_DOMAIN ),
				'type'     => 'url',
				'default'  => '',
				'required' => false,
			),
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function render( array $settings, array $context = array() ) {
		$links = array();
		$map   = array(
			'social_x_url'         => 'X',
			'social_instagram_url' => 'Instagram',
			'social_facebook_url'  => 'Facebook',
			'social_linkedin_url'  => 'LinkedIn',
		);

		foreach ( $map as $key => $label ) {
			$url = Escaper::public_url( (string) ( $settings[ $key ] ?? '' ) );

			if ( '' === $url ) {
				continue;
			}

			$links[] = array(
				'label' => $label,
				'url'   => $url,
			);
		}

		if ( empty( $links ) ) {
			return '';
		}

		ob_start();
		?>
		<section class="mmsm-component mmsm-component-social" aria-label="<?php echo esc_attr__( 'Social links', MMSM_TEXT_DOMAIN ); ?>">
			<ul class="mmsm-social-list">
				<?php foreach ( $links as $link ) : ?>
					<li>
						<a class="mmsm-social-link" href="<?php echo esc_url( $link['url'] ); ?>">
							<?php echo esc_html( $link['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
		<?php

		return (string) ob_get_clean();
	}
}
