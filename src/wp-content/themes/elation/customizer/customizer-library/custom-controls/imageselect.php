<?php
/**
 * Customize for Customizer help, extend the WP customizer
 *
 * @package 	Customizer_Library
 * @author		Devin Price, The Theme Foundry
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return NULL;
}

class Customizer_Library_Imageselect extends WP_Customize_Control {

	public $default;

	public function render_content() {
		global $_wp_additional_image_sizes;

		$elation_imgs_dropdown = '<select data-customize-setting-link="' .esc_attr( $this->id ). '">';

		$elation_imgs_dropdown .= '<option value="full" ' . selected( 'full', $this->default, false ) . '>' . __( 'Full', 'elation' ) . '</option>';

		foreach ( get_intermediate_image_sizes() as $_size ) {
			$elation_imgs_dropdown .= '<option value="' . esc_attr( $_size ) . '" ' . selected( $_size, $this->default, false ) . '>';

			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$elation_imgs_dropdown .=  esc_attr( ucwords( str_replace( array( '_', '-' ), ' ', $_size ) ) ) . ' (' . esc_attr( get_option( "{$_size}_size_w" ) ) . ' X ' . esc_attr( get_option( "{$_size}_size_h" ) ) . ')';
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$elation_imgs_dropdown .=  esc_attr( ucwords( str_replace( array( '_', '-' ), ' ', $_size ) ) ) . ' (' . esc_attr( $_wp_additional_image_sizes[ $_size ]['width'] ) . ' X ' . esc_attr( $_wp_additional_image_sizes[ $_size ]['height'] ) . ')';
			}

			$elation_imgs_dropdown .= '</option>';
		}

		$elation_imgs_dropdown .= '</select>';

		$elation_imgs_html = array(
			'select'      => array(
				'data-customize-setting-link'  => array(),
			),
			'option'     => array(
				'value'  => array(),
			),
		);
		printf( '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>', esc_attr( $this->label ), wp_kses( $elation_imgs_dropdown, $elation_imgs_html ) );

		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . wp_kses_post( $this->description ) . '</span>';
		}

	}

}
