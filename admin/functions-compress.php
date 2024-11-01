<?php
/**
 * Compress API Functions
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Compress PDF File.
 *
 * @since    1.0.0
 * @param    int|null $file_path    File path.
 * @param    boolean  $auto    Auto compress.
 */
function woow_pdf_compress_pdf($file_path) {
	
	global $wp_filesystem;
	// Initialize the WP_Filesystem
	if (empty($wp_filesystem)) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}

    // Get the settings
    $options = get_option('woow_pdf_display_settings_compress');
    $response = false;

    if ( isset( $options['woow_pdf_compress_active'] ) ) {

        if ( isset( $options['woow_pdf_compress_quality'] ) ) {
            $compress_type = $options['woow_pdf_compress_quality'];
        }

        // API Section
        $api_compress_url = WOOW_PDF_API_URL . 'compress-pdfs';

        // Read file content
        $file_name = wp_basename($file_path);
		$file_content = $wp_filesystem->get_contents($file_path);

        if ($file_content === false) {
            return 'Failed to read file content.';
        }

        $boundary = wp_generate_uuid4(); // Generate a unique boundary

        // Create the multipart/form-data body
        $body = "--$boundary\r\n";
        $body .= "Content-Disposition: form-data; name=\"file_upload\"; filename=\"$file_name\"\r\n";
        $body .= "Content-Type: application/pdf\r\n\r\n";
        $body .= $file_content . "\r\n";
        $body .= "--$boundary\r\n";
        $body .= "Content-Disposition: form-data; name=\"compress_type\"\r\n\r\n";
        $body .= $compress_type . "\r\n";
        $body .= "--$boundary--\r\n";

        // Set up the headers
        $headers = array(
            'X-App-Key' => WOOW_PDF_APP_KEY,
            'X-Host'    => WOOW_PDF_HOST_KEY,
            'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
            'Content-Length' => strlen($body)
        );

        // Send the request
        $response = wp_remote_post($api_compress_url, array(
            'method'    => 'POST',
            'body'      => $body,
            'headers'   => $headers,
            'timeout'   => 60,
            'sslverify' => false // Set to true in production for better security
        ));

        // Handle response
        if (is_wp_error($response)) {
            return 'Request failed: ' . $response->get_error_message();
        }

        $response_body = wp_remote_retrieve_body($response);

        // Decode response
        $decoded_response = json_decode($response_body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Failed to decode JSON response.';
        }

        return $decoded_response;
    }

    return 'Compression not active or file path is missing.';
}

/**
 * PDF File Upload Auto Compress.
 *
 * @since    1.0.0
 * @param    int $attachment_id    File ID.
 */
function woow_pdf_handle_file_upload_compress( $attachment_id ) {
    $file_path = get_attached_file($attachment_id);
    $html = '';

    if ( get_post_mime_type( $attachment_id ) === 'application/pdf' ) {

        $options_2 = get_option( 'woow_pdf_display_settings_watermark' );

        // Check if automatic compressing is enabled and watermarking is disabled
        if ( ! isset( $options_2['woow_pdf_watermark_active'] ) ) {
            // Compress the PDF file
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
                    
                    global $wp_filesystem;
                    if ( empty( $wp_filesystem ) ) {
                        require_once ABSPATH . '/wp-admin/includes/file.php';
                        WP_Filesystem();
                    }

                    $updated_file = $wp_filesystem->put_contents( $file_path, $compressed_pdf_body );

                    // Check if file update was successful
                    if ( $updated_file !== false ) {
                        // Update attachment metadata
                        wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $file_path ) );
                    } else {
                        // Error occurred during upload
                        $html = '<div class="settings-error notice is-dismissible error">';
                        $html .= '<p>' . __('Error uploading compressed PDF to media library.', 'woow-pdf') . '</p>';
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
add_action( 'add_attachment', 'woow_pdf_handle_file_upload_compress' );