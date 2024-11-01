<?php
/**
 * Compress Settings
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Initialize Options for the admin area.
 *
 * @since    1.0.0
 */

function woow_pdf_initialize_options_compress() {

    if ( false === get_option( 'woow_pdf_display_settings_compress' ) ) {
        add_option( 'woow_pdf_display_settings_compress' );
    }

    add_settings_section(
        'compress_settings_section',
        '',
        'woow_pdf_compress_options_callback',
        'woow_pdf_display_settings_compress'
    );

    add_settings_field(
        'woow_pdf_compress_active',
        __( 'Enable Compress PDF:', 'woow-pdf' ),
        'woow_pdf_compress_active_callback',
        'woow_pdf_display_settings_compress',
        'compress_settings_section',
        array(
            __( 'Activate this setting to compress PDF files.', 'woow-pdf' ),
        )
    );

    add_settings_field(
        'woow_pdf_compress_quality',
        __( 'Select PDF Quality:', 'woow-pdf' ),
        'woow_pdf_compress_quality_callback',
        'woow_pdf_display_settings_compress',
        'compress_settings_section',
        array(
            __( 'Default Compress', 'woow-pdf' ),
            __( 'Low Compress', 'woow-pdf' ),
            __( 'Medium Compress', 'woow-pdf' ),
            __( 'High Compress', 'woow-pdf' ),
        )
    );

    add_settings_field(
        'woow_pdf_compress_autocompress_new',
        __( 'Autocompress PDF:', 'woow-pdf' ),
        'woow_pdf_compress_autocompress_new_callback',
        'woow_pdf_display_settings_compress',
        'compress_settings_section',
        array(
            __( 'Automatically compress newly uploaded PDF files.', 'woow-pdf' ),
        )
    );

    register_setting(
        'woow_pdf_display_settings_compress',
        'woow_pdf_display_settings_compress'
    );
}
add_action( 'admin_init', 'woow_pdf_initialize_options_compress' );

/**
 * Options Callback.
 *
 * @since    1.0.0
 */
function woow_pdf_compress_options_callback() {
    echo '<h5 class="mb-4">' . esc_html( __( 'Adjust your settings for PDF compression:', 'woow-pdf' ) ) . '</h5>';
}

/**
 * Active Compress PDF Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_compress_active_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_compress' );
    $checked = isset( $options['woow_pdf_compress_active'] ) ? checked( 1, $options['woow_pdf_compress_active'], false ) : '';
	?>

	<input type="checkbox" id="woow_pdf_compress_active" name="woow_pdf_display_settings_compress[woow_pdf_compress_active]" value="1" <?php echo esc_attr( $checked ); ?> />
	<label for="woow_pdf_compress_active"><?php echo esc_html( $args[0] ); ?></label>

	<?php
}

/**
 * Compress Quality Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_compress_quality_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_compress' );
    $checked_default = isset( $options['woow_pdf_compress_quality'] ) ? checked( 'default', $options['woow_pdf_compress_quality'], false ) : 'checked="checked"';
	$checked_printer = isset( $options['woow_pdf_compress_quality'] ) ? checked( 'printer', $options['woow_pdf_compress_quality'], false ) : '';
	$checked_ebook   = isset( $options['woow_pdf_compress_quality'] ) ? checked( 'ebook', $options['woow_pdf_compress_quality'], false ) : '';
	$checked_screen  = isset( $options['woow_pdf_compress_quality'] ) ? checked( 'screen', $options['woow_pdf_compress_quality'], false ) : '';
	?>

	<input type="radio" id="woow_pdf_compress_quality_default" name="woow_pdf_display_settings_compress[woow_pdf_compress_quality]" value="default" <?php echo esc_attr( $checked_default ); ?> style="margin-bottom:6px" />
	<label for="woow_pdf_compress_quality_default" style="margin-bottom:9px"> <?php echo esc_html( $args[0] ); ?></label><br>

	<input type="radio" id="woow_pdf_compress_quality_low" name="woow_pdf_display_settings_compress[woow_pdf_compress_quality]" value="printer" <?php echo esc_attr( $checked_printer ); ?> style="margin-bottom:6px" />
	<label for="woow_pdf_compress_quality_low" style="margin-bottom:9px"> <?php echo esc_html( $args[1] ); ?></label><br>

	<input type="radio" id="woow_pdf_compress_quality_medium" name="woow_pdf_display_settings_compress[woow_pdf_compress_quality]" value="ebook" <?php echo esc_attr( $checked_ebook ); ?> style="margin-bottom:6px" />
	<label for="woow_pdf_compress_quality_medium" style="margin-bottom:9px"> <?php echo esc_html( $args[2] ); ?></label><br>

	<input type="radio" id="woow_pdf_compress_quality_high" name="woow_pdf_display_settings_compress[woow_pdf_compress_quality]" value="screen" <?php echo esc_attr( $checked_screen ); ?> style="margin-bottom:6px" />
	<label for="woow_pdf_compress_quality_high" style="margin-bottom:9px"> <?php echo esc_html( $args[3] ); ?></label>

	<?php
}

/**
 * Autocompress new Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_compress_autocompress_new_callback( $args ) {
	?>
	<span class="dashicons dashicons-yes woow-pdf-tick-icon"></span>
	<label for="woow_pdf_compress_autocompress_new"><?php echo esc_html( $args[0] ); ?></label>

	<?php
}
