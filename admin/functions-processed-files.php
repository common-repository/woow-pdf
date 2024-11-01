<?php
/**
 * Functions of Processed Files
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Backup Original PDF File
 *
 * @since    1.0.0
 * @param    int $attachment_id    File ID.
 */
function woow_pdf_handle_file_upload_backup( $attachment_id ) {

    // Check if the uploaded file is a PDF
    if ( get_post_mime_type( $attachment_id ) === 'application/pdf' ) {

        $options_general_settings = get_option( 'woow_pdf_display_general_settings' );
        $wp_upload_dir = wp_upload_dir();

        if ( (int) $options_general_settings['woow_pdf_general_backup'] && ! get_post_meta( $attachment_id, '_wp_attached_file_backup', true ) ) {

            copy( get_attached_file( $attachment_id ), $wp_upload_dir['basedir'] . '/woowpdf_files_data/backup/' . basename( get_attached_file( $attachment_id ) ) );
            update_post_meta( $attachment_id, '_wp_attached_file_backup', get_post_meta( $attachment_id, '_wp_attached_file', true ) );
        }
    }
}

add_action( 'add_attachment', 'woow_pdf_handle_file_upload_backup' );