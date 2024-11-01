<?php

/**
 * Fired during plugin activation
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/includes
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/includes
 * @author     Workforce Commerce <info@workforcecommerce.com>
 */
class Woow_Pdf_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// wn-custom-code
		$upload_dir = wp_upload_dir();
		$pdf_dirname = $upload_dir['basedir'] . '/woowpdf_files_data';

		if ( ! file_exists( $pdf_dirname ) ) {
			wp_mkdir_p( $pdf_dirname );
		}

		$pdf_dirname = $upload_dir['basedir'] . '/woowpdf_files_data/backup';
		if ( ! file_exists( $pdf_dirname ) ) {
			wp_mkdir_p( $pdf_dirname );
		}

		self::set_default_values_general_settings();
		self::set_default_values_compress_settings();
		self::set_default_values_watermark_settings();
	}

	/**
	 * General Settings Value.
	 *
	 * Set default values.
	 *
	 * @since    2.1.0
	 */
	public static function set_default_values_general_settings() {

		$get_options = get_option( 'woow_pdf_display_general_settings' );

		if ( ! is_array( $get_options ) ) {
			$get_options = array();
		}

		if ( ! isset( $get_options['woow_pdf_general_backup'] ) ) {
			$get_options['woow_pdf_general_backup'] = 1;
		}

		update_option( 'woow_pdf_display_general_settings', $get_options );
	}

	/**
	 * Compress Settings Value.
	 *
	 * Set default values.
	 *
	 * @since    1.0.0
	 */
	public static function set_default_values_compress_settings() {

		$get_options = get_option( 'woow_pdf_display_settings_compress' );

		if ( ! is_array( $get_options ) ) {
			$get_options = array();
		}

		if ( ! isset( $get_options['woow_pdf_compress_active'] ) ) {
			$get_options['woow_pdf_compress_active'] = 1;
		}

		if ( ! isset( $get_options['woow_pdf_compress_quality'] ) ) {
			$get_options['woow_pdf_compress_quality'] = 'default';
		}

		update_option( 'woow_pdf_display_settings_compress', $get_options );
	}

	/**
	 * Watermark Settings Value.
	 *
	 * Set default values.
	 *
	 * @since    1.0.0
	**/
	public static function set_default_values_watermark_settings() {

		$get_gral_options   = get_option( 'woow_pdf_display_settings_watermark' );
		$get_format_options = get_option( 'woow_pdf_display_settings_format_watermark' );

		if ( ! is_array( $get_gral_options ) ) {
			$get_gral_options = array();
		}

		if ( ! isset( $get_gral_options['woow_pdf_watermark_active'] ) ) {
			$get_gral_options['woow_pdf_watermark_active'] = 1;
        }

		// =================

		if ( ! is_array( $get_format_options ) ) {
			$get_format_options = array();
		}

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_text'] ) ) {
			$get_format_options['woow_pdf_format_watermark_text'] = get_bloginfo();
        }

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_font_family'] ) ) {
			$get_format_options['woow_pdf_format_watermark_font_family'] = 'Helvetica-Bold';
		}

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_text_color'] ) ) {
			$get_format_options['woow_pdf_format_watermark_text_color'] = '#673ab7';
		}

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_text_postion'] ) ) {
			$get_format_options['woow_pdf_format_watermark_text_postion'] = 'center_center';
        }

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_text_layer'] ) ) {
			$get_format_options['woow_pdf_format_watermark_text_layer'] = 'below';
        }

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_text_size'] ) ) {
			$get_format_options['woow_pdf_format_watermark_text_size'] = '60';
		}

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_opacity'] ) ) {
			$get_format_options['woow_pdf_format_watermark_opacity'] = '40';
		}

		if ( ! isset( $get_format_options['woow_pdf_format_watermark_rotation'] ) ) {
			$get_format_options['woow_pdf_format_watermark_rotation'] = '0';
		}

		update_option( 'woow_pdf_display_settings_watermark', $get_gral_options );
		update_option( 'woow_pdf_display_settings_format_watermark', $get_format_options );
	}
	
}
