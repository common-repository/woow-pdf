<?php
/**
 * Admin General Settings
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Initialize Options for the general admin area.
 *
 * @since    1.0.0
 */
function woow_pdf_initialize_general_options() {

    if ( false === get_option( 'woow_pdf_display_general_settings' ) ) {
        add_option( 'woow_pdf_display_general_settings' );
    }

    add_settings_section(
        'general_settings_section',
        '',
        'woow_pdf_general_options_callback',
        'woow_pdf_display_general_settings'
    );

    add_settings_field(
        'woow_pdf_general_backup',
        __( 'Would you like to make backups of the original files?', 'woow-pdf' ),
        'woow_pdf_general_backup_callback',
        'woow_pdf_display_general_settings',
        'general_settings_section',
        array(
            'No',
            'Yes',
        )
    );

    register_setting(
        'woow_pdf_display_general_settings',
        'woow_pdf_display_general_settings'
    );
}
add_action( 'admin_init', 'woow_pdf_initialize_general_options' );

/**
 * Options General Callback.
 *
 * @since    1.0.0
 */
function woow_pdf_general_options_callback() {
    echo '<h5 class="mb-4">' . esc_html( __( 'Adjust your tools configurations:', 'woow-pdf' ) ) . '</h5>';
}

/**
 * Backup Original File Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_general_backup_callback( $args ) {

    $options = get_option( 'woow_pdf_display_general_settings' );
    $checked_no  = isset( $options['woow_pdf_general_backup'] ) ? checked( 0, $options['woow_pdf_general_backup'], false ) : '';
    $checked_yes = isset( $options['woow_pdf_general_backup'] ) ? checked( 1, $options['woow_pdf_general_backup'], false ) : 'checked="checked"';

    ?>
    <input type="radio" id="woow_pdf_general_backup_no" name="woow_pdf_display_general_settings[woow_pdf_general_backup]" value="0" <?php echo esc_attr( $checked_no ); ?>>
    <label for="woow_pdf_general_backup_no" style="margin-right: 14px;"><?php echo esc_html( $args[0] ); ?></label>&nbsp;
    <input type="radio" id="woow_pdf_general_backup_yes" name="woow_pdf_display_general_settings[woow_pdf_general_backup]" value="1" <?php echo esc_attr( $checked_yes ); ?>>
    <label for="woow_pdf_general_backup_yes"><?php echo esc_html( $args[1] ); ?></label>
    <div style="margin-top: 20px;">
        <p><small><?php esc_html_e( 'You can locate the backup files on your server:', 'woow-pdf' ); ?></small></p>
        <p><strong><?php echo esc_html( 'wp-content/uploads/woowpdf_files_data/backup' ); ?></strong></p>
    </div>
    <?php
}