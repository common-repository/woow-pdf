<?php
/**
 * Watermark and Compress API Functions
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * PDF File Upload Auto Watermark and Auto Compress.
 *
 * @since    1.0.0
 * @param    int $attachment_id    File ID.
 */
function woow_pdf_handle_file_upload_watermark_compress( $attachment_id ) {

	global $wp_filesystem;
	// Initialize the WP_Filesystem
	if (empty($wp_filesystem)) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}
	
    $file_path = get_attached_file($attachment_id);
    $html      = '';

    if ( get_post_mime_type( $attachment_id ) === 'application/pdf' ) {
        
        $options_auto_compress = get_option( 'woow_pdf_display_settings_compress' );
        $options_auto_watermark = get_option( 'woow_pdf_display_settings_watermark' );

        // Check if automatic compressing and watermarking are enabled
        if ( isset( $options_auto_compress['woow_pdf_compress_active'] ) && isset( $options_auto_watermark['woow_pdf_watermark_active'] ) ) {

            // ========== Watermark API ==========
            $watermark_response = woow_pdf_watermark_pdf( $file_path );

            // Check if watermarking was successful
            if ($watermark_response === false || !isset($watermark_response['pdf_file_url'])) {
                // Handle API response error
                $html = '<div class="settings-error notice is-dismissible error">';
                $html .= '<p>' . __('Error watermarking PDF using API.', 'woow-pdf') . '</p>';
                $html .= '</div>';
            } else {

                $watermarked_pdf_url = WOOW_PDF_API_URL . $watermark_response['pdf_file_url'];
                $watermarked_pdf_download = wp_remote_get($watermarked_pdf_url);

                // Check if download was successful
                if (!is_wp_error($watermarked_pdf_download) && wp_remote_retrieve_response_code($watermarked_pdf_download) === 200) {

                    $watermarked_pdf_body = wp_remote_retrieve_body($watermarked_pdf_download);

                    $attachment_data = array(
                        'ID'           => $attachment_id,
                        'post_content'   => '',
                        'post_status'    => 'inherit',
                    );
                    $updated_attachment_id = wp_update_post( $attachment_data );

                    if (!is_wp_error($updated_attachment_id)) {
                        // Update the attachment file with the watermarked PDF content
                        $wp_filesystem->put_contents($file_path, $watermarked_pdf_body, FS_CHMOD_FILE);
                        $file_path;

                    } else {
                        // Error occurred during attachment update
                        $html = '<div class="settings-error notice is-dismissible error">';
                        $html .= '<p>' . __('Error updating compressed PDF attachment.', 'woow-pdf') . '</p>';
                        $html .= '</div>';
                    }

                } else {
                    // Error occurred while downloading watermarked PDF
                    $html = '<div class="settings-error notice is-dismissible error">';
                    $html .= '<p>' . __('Error downloading watermarked PDF from API.', 'woow-pdf') . '</p>';
                    $html .= '</div>';
                }
            }

            // ========== Compress API ==========
            $compress_response = woow_pdf_compress_pdf( $file_path );

            if ($compress_response === false || !isset($compress_response['compress_pdf_url'])) {
                // Handle API response error
                $html = '<div class="settings-error notice is-dismissible error">';
                $html .= '<p>' . __('Error compressing PDF using API.', 'woow-pdf') . '</p>';
                $html .= '</div>';
            } else {
                $compressed_pdf_url = WOOW_PDF_API_URL . $compress_response['compress_pdf_url'];
                $compressed_pdf_download = wp_remote_get($compressed_pdf_url);

                if (!is_wp_error($compressed_pdf_download) && wp_remote_retrieve_response_code($compressed_pdf_download) === 200) {

                    $compressed_pdf_body = wp_remote_retrieve_body($compressed_pdf_download);
                    
                    // Update the existing attachment's metadata
                    $attachment_data = array(
                        'ID'           => $attachment_id,
                        'post_content'   => '',
                        'post_status'    => 'inherit',
                    );
                    $updated_attachment_id = wp_update_post( $attachment_data );

                    if (!is_wp_error($updated_attachment_id)) {
                        // Update the attachment file with the compressed PDF content
                        $updated_file = $wp_filesystem->put_contents($file_path, $compressed_pdf_body);

                        // Check if file update was successful
                        if ($updated_file !== false) {
                            // Update attachment metadata
                            wp_update_attachment_metadata( $updated_attachment_id, wp_generate_attachment_metadata( $updated_attachment_id, $file_path ) );
                        } else {
                            // Error occurred during upload
                            $html = '<div class="settings-error notice is-dismissible error">';
                            $html .= '<p>' . __('Error uploading compressed PDF to media library.', 'woow-pdf') . '</p>';
                            $html .= '</div>';
                        }
                    } else {
                        // Error occurred during attachment update
                        $html = '<div class="settings-error notice is-dismissible error">';
                        $html .= '<p>' . __('Error updating compressed PDF attachment.', 'woow-pdf') . '</p>';
                        $html .= '</div>';
                    }
                } else {
                    // Error occurred while downloading compressed PDF
                    $html = '<div class="settings-error notice is-dismissible error">';
                    $html .= '<p>' . __('Error downloading compressed PDF from API.', 'woow-pdf') . '</p>';
                    $html .= '</div>';
                }
            }

        }
    }

    return $html;
}
add_action( 'add_attachment', 'woow_pdf_handle_file_upload_watermark_compress' );