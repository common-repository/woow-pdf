<?php
/**
 * Watermark API Functions
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 /**
 * Watermark PDF File.
 *
 * @since    1.0.0
 * @param    int|null $file_path    File path.
 * @param    boolean  $auto    Auto Watermark.
 */
function woow_pdf_watermark_pdf( $file_path ) {
	
	global $wp_filesystem;
	// Initialize the WP_Filesystem
	if (empty($wp_filesystem)) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}

    $options_main_1 = get_option( 'woow_pdf_display_settings_watermark' );
    $options        = get_option( 'woow_pdf_display_settings_format_watermark' );
    $response       = false;

    if ( isset( $options_main_1['woow_pdf_watermark_active'] ) ) {

        if ( isset( $options['woow_pdf_format_watermark_text'] ) ) {
            $wtrmrk_text = $options['woow_pdf_format_watermark_text'];
        }
        if ( isset( $options['woow_pdf_format_watermark_image'] ) ) {
            $wtrmrk_image = wp_get_attachment_url( $options['woow_pdf_format_watermark_image'] );
        }
        if ( isset( $options['woow_pdf_format_watermark_font_family'] ) ) {
            $wtrmrk_family = $options['woow_pdf_format_watermark_font_family'];
        }
        if ( isset( $options['woow_pdf_format_watermark_text_color'] ) ) {
            $wtrmrk_color = $options['woow_pdf_format_watermark_text_color'];
        }
        if ( isset( $options['woow_pdf_format_watermark_text_postion'] ) ) {
            $wtrmrk_position = $options['woow_pdf_format_watermark_text_postion'];
        }
        if ( isset( $options['woow_pdf_format_watermark_text_layer'] ) ) {
            $wtrmrk_layer = $options['woow_pdf_format_watermark_text_layer'];
        }
        if ( isset( $options['woow_pdf_format_watermark_image_layer'] ) ) {
            $wtrmrk_image_layer = $options['woow_pdf_format_watermark_image_layer'];
        }
        if ( isset( $options['woow_pdf_format_watermark_text_size'] ) ) {
            $wtrmrk_size = $options['woow_pdf_format_watermark_text_size'];
        }
        if ( isset( $options['woow_pdf_format_watermark_opacity'] ) ) {
            $wtrmrk_opacity = intval($options['woow_pdf_format_watermark_opacity']);
            $wtrmrk_opacity_int = $wtrmrk_opacity / 100;
            $wtrmrk_opacity_final = strval($wtrmrk_opacity_int);
        }
        if ( isset( $options['woow_pdf_format_watermark_rotation'] ) ) {
            $wtrmrk_rotation = $options['woow_pdf_format_watermark_rotation'];
        }

        // API Section
        $api_watermark_url = WOOW_PDF_API_URL . 'add-watermark-to-pdf';
		
		// Read file content
		$file_name = wp_basename($file_path);
		$file_content = $wp_filesystem->get_contents($file_path);

		if ($file_content === false) {
			return 'Failed to read file content.';
		}

        if ( isset( $options['woow_pdf_format_watermark_mode'] )
                && $options['woow_pdf_format_watermark_mode'] == 0 
                && checked( $options['woow_pdf_format_watermark_mode'], 0, false ) 
                && $wtrmrk_text !== ''
                && $wtrmrk_size !== ''
                && $wtrmrk_opacity_final !== '' 
                && $wtrmrk_rotation !== ''
           ) {

            $boundary = wp_generate_uuid4(); // Generate a unique boundary
			
			// Create the multipart/form-data body
			$body = "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"file_upload\"; filename=\"$file_name\"\r\n";
			$body .= "Content-Type: application/pdf\r\n\r\n";
			$body .= $file_content . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"watermark_text\"\r\n\r\n";
			$body .= $wtrmrk_text . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"watermark_color\"\r\n\r\n";
			$body .= $wtrmrk_color . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"watermark_position\"\r\n\r\n";
			$body .= $wtrmrk_position . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"text_font_size\"\r\n\r\n";
			$body .= $wtrmrk_size . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"text_transparency\"\r\n\r\n";
			$body .= $wtrmrk_opacity_final . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"text_rotation\"\r\n\r\n";
			$body .= $wtrmrk_rotation . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"font_family\"\r\n\r\n";
			$body .= $wtrmrk_family . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"watermark_layer\"\r\n\r\n";
			$body .= $wtrmrk_layer . "\r\n";
			$body .= "--$boundary--\r\n";
			
			// Set up the headers
			$headers = array(
				'X-App-Key' => WOOW_PDF_APP_KEY,
				'X-Host'    => WOOW_PDF_HOST_KEY,
				'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
				'Content-Length' => strlen($body)
			);

			// Send the request
			$response = wp_remote_post($api_watermark_url, array(
				'method'    => 'POST',
				'body'      => $body,
				'headers'   => $headers,
				'timeout'   => 60,
				'sslverify' => false // Set to true in production for better security
			));
			
        }
        else if ( isset( $options['woow_pdf_format_watermark_mode'] )
                    && $options['woow_pdf_format_watermark_mode'] == 1 
                    && checked( $options['woow_pdf_format_watermark_mode'], 1, false ) 
                    && $wtrmrk_image !== false
                ) {
			
			// Read file content
			$image_file_name = wp_basename($wtrmrk_image);
			$image_file_content = $wp_filesystem->get_contents($wtrmrk_image);

			if ($image_file_content === false) {
				return 'Failed to read file content.';
			}
			
			$boundary = wp_generate_uuid4(); // Generate a unique boundary

			// Create the multipart/form-data body
			$body = "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"file_upload\"; filename=\"$file_name\"\r\n";
			$body .= "Content-Type: application/pdf\r\n\r\n";
			$body .= $file_content . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"image_upload\"; filename=\"$image_file_name\"\r\n";
			$body .= "Content-Type: image/png\r\n\r\n";
			$body .= $image_file_content . "\r\n";
			$body .= "--$boundary\r\n";
			$body .= "Content-Disposition: form-data; name=\"image_watermark_option\"\r\n\r\n";
			$body .= $wtrmrk_image_layer . "\r\n";
			$body .= "--$boundary--\r\n";
			
			// Set up the headers
			$headers = array(
				'X-App-Key' => WOOW_PDF_APP_KEY,
				'X-Host'    => WOOW_PDF_HOST_KEY,
				'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
				'Content-Length' => strlen($body)
			);

			// Send the request
			$response = wp_remote_post($api_watermark_url, array(
				'method'    => 'POST',
				'body'      => $body,
				'headers'   => $headers,
				'timeout'   => 60,
				'sslverify' => false // Set to true in production for better security
			));
			
        }

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

    return 'Watermark not active or file path is missing.';
}

 /**
 * PDF File Upload Auto Watermark.
 *
 * @since    1.0.0
 * @param    int $attachment_id    File ID.
 */
function woow_pdf_handle_file_upload_watermark( $attachment_id ) {
    $file_path = get_attached_file($attachment_id);
    $html = '';

    // Check if the uploaded file is a PDF
    if ( get_post_mime_type( $attachment_id ) === 'application/pdf' ) {
        // Get watermark settings
        
        $options_main_2 = get_option( 'woow_pdf_display_settings_compress' );

        // Check if automatic watermarking is enabled and compressing is disabled
        if ( ! isset( $options_main_2['woow_pdf_compress_active'] ) ) {
            // Watermark the PDF file
            $watermark_response = woow_pdf_watermark_pdf( $file_path );

            // Check if watermarking was successful
            if ($watermark_response === false || !isset($watermark_response['pdf_file_url'])) {
                // Handle API response error
                $html = '<div class="settings-error notice is-dismissible error">';
                $html .= '<p>' . __('Error watermarking PDF using API.', 'woow-pdf') . '</p>';
                $html .= '</div>';
            } else {
                // Get the URL of the watermarked PDF
                $watermarked_pdf_url = WOOW_PDF_API_URL . $watermark_response['pdf_file_url'];

                // Download the watermarked PDF
                $watermarked_pdf_download = wp_remote_get($watermarked_pdf_url);

                // Check if download was successful
                if (!is_wp_error($watermarked_pdf_download) && wp_remote_retrieve_response_code($watermarked_pdf_download) === 200) {

                    $watermarked_pdf_body = wp_remote_retrieve_body($watermarked_pdf_download);
                    
                    // Update the attachment with the watermarked PDF content
                    
                    // Update the attachment's metadata to point to the watermarked PDF
                    $attachment_data = array(
                        'ID'           => $attachment_id,
                        'post_content' => '', // Clear any existing content
                        'post_status'  => 'inherit',
                    );
                    
                    // Update the attachment
                    $updated_attachment_id = wp_update_post( $attachment_data );

                    // Check if attachment update was successful
                    if (!is_wp_error($updated_attachment_id)) { 
                        global $wp_filesystem;
                        if ( empty( $wp_filesystem ) ) {
                            require_once ABSPATH . '/wp-admin/includes/file.php';
                            WP_Filesystem();
                        }
                        
                        // Update the attachment file with the watermarked PDF content
                        $updated_file = $wp_filesystem->put_contents( $file_path, $watermarked_pdf_body );
                        
                        // Check if file update was successful
                        if ($updated_file !== false) {
                            // Update attachment metadata
                            wp_update_attachment_metadata( $updated_attachment_id, wp_generate_attachment_metadata( $updated_attachment_id, $file_path ) );
                        } else {
                            // Error occurred during file update
                            $html = '<div class="settings-error notice is-dismissible error">';
                            $html .= '<p>' . __('Error updating watermarked PDF file.', 'woow-pdf') . '</p>';
                            $html .= '</div>';
                        }
                    } else {
                        // Error occurred during attachment update
                        $html = '<div class="settings-error notice is-dismissible error">';
                        $html .= '<p>' . __('Error updating watermarked PDF attachment.', 'woow-pdf') . '</p>';
                        $html .= '</div>';
                    }
                } else {
                    // Error occurred while downloading watermarked PDF
                    $html = '<div class="settings-error notice is-dismissible error">';
                    $html .= '<p>' . __('Error downloading watermarked PDF from API.', 'woow-pdf') . '</p>';
                    $html .= '</div>';
                }
            }
        }
    }

    return $html;
}
add_action( 'add_attachment', 'woow_pdf_handle_file_upload_watermark' );