<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/includes
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/includes
 * @author     Workforce Commerce <info@workforcecommerce.com>
 */
class Woow_Pdf_Deactivator {

	/**
	 * Handles tasks to be performed during plugin deactivation.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wp_filesystem;

		// Initialize the WP Filesystem API
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		WP_Filesystem();

		$upload_dir = wp_upload_dir();
		$base_dir = $upload_dir['basedir'] . '/woowpdf_files_data';
		$backup_dir = $base_dir . '/backup';

		if ( $wp_filesystem->is_dir( $backup_dir ) ) {
			// Get all files excluding '.' and '..'
			$files = array_diff( $wp_filesystem->dirlist( $backup_dir ), array( '.', '..' ) );
			$has_pdf = false;

			foreach ( $files as $file_info ) {
				if ( isset( $file_info['name'] ) && pathinfo( $file_info['name'], PATHINFO_EXTENSION ) === 'pdf' ) {
					$has_pdf = true;
					break;
				}
			}

			// If no PDF files are found, delete the directory
			if ( ! $has_pdf ) {
				$wp_filesystem->rmdir( $backup_dir );
			}
		}
	}
}