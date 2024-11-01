<?php

/**
 * Function showing configuration page
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin/partials
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function woow_pdf_content_page_setting() {

    $logo_svg = WOOW_PDF_ASSETS_PLUGIN_PATH . 'assets/img/woowpdf-logo.svg';
    $options  = get_option( 'woow_pdf_display_settings_watermark' );
    ?>

    <div class="wrap">
		<div class="plugin-logo">
            <img src="<?php echo esc_url( $logo_svg ); ?>" alt="logo woowpdf" />
        </div>

        <?php
            $nonce_settings = wp_create_nonce();
            $active_tab     = isset( $_GET['tab'] ) && isset( $_GET['nonce_woow_pdf_settings_tab'] ) && wp_verify_nonce( sanitize_key( $_GET['nonce_woow_pdf_settings_tab'] ) ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'setting_options';
        ?>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="?page=woow-pdf-content-setting&tab=setting_options&nonce_woow_pdf_settings_tab=<?php echo sanitize_key( $nonce_settings ); ?>" class="nav-link <?php echo 'setting_options' === $active_tab ? 'active tab-woowpdf' : ''; ?>"><?php echo esc_html( __( 'General', 'woow-pdf' ) ); ?></a>
            </li>
            <li class="nav-item">
                <a href="?page=woow-pdf-content-setting&tab=compress_options&nonce_woow_pdf_settings_tab=<?php echo sanitize_key( $nonce_settings ); ?>" class="nav-link <?php echo 'compress_options' === $active_tab ? 'active tab-woowpdf' : ''; ?>"><?php echo esc_html( __( 'Compress PDF', 'woow-pdf' ) ); ?></a>
            </li>
            <li class="nav-item">
            <a href="?page=woow-pdf-content-setting&tab=watermark_options&nonce_woow_pdf_settings_tab=<?php echo sanitize_key( $nonce_settings ); ?>" class="nav-link <?php echo 'watermark_options' === $active_tab ? 'active tab-woowpdf' : ''; ?>"><?php echo esc_html( __( 'Add Watermark', 'woow-pdf' ) ); ?></a>
            </li>
        </ul>
        <!-- General option -->
        <?php if ( 'setting_options' === $active_tab ) : ?>
        <div class="wrap mt-0 me-0">           
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 px-4 pt-5 pb-4 bg-white general-settings-box">
                        <form action="options.php" method="POST">
                            <?php settings_fields( 'woow_pdf_display_general_settings' ); ?>
                            <?php do_settings_sections( 'woow_pdf_display_general_settings' ); ?>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Compress option -->
        <?php elseif ( 'compress_options' === $active_tab ) : ?>
        <div class="wrap mt-0 me-0">           
            <div class="container-fluid">
                <div class="row">
                    <div id="woow-pdf-compress-box" class="col-12 px-4 pt-5 pb-4 bg-white">
                        <form method="post" name="woow_pdf_form_compress" action="options.php">
                            <?php settings_fields( 'woow_pdf_display_settings_compress' ); ?>
                            <?php do_settings_sections( 'woow_pdf_display_settings_compress' ); ?>

                            <div class="woow_pdf_wrapper_buttons">
                                <?php submit_button(); ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Watermark option -->
        <?php elseif ( 'watermark_options' === $active_tab ) : ?>
        <div class="wrap mt-0 me-0">           
            <div class="container-fluid">
                <div class="row mb-4">
                    <div id="woow-pdf-watermark-first-box" class="col-12 px-4 pt-5 pb-4 bg-white">
                        <form method="post" name="woow_pdf_form_watermark" action="options.php">
                            <?php settings_fields( 'woow_pdf_display_settings_watermark' ); ?>
                            <?php do_settings_sections( 'woow_pdf_display_settings_watermark' ); ?>
                            <div class="woow_pdf_wrapper_buttons">
                                <?php submit_button(); ?>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if ( isset( $options['woow_pdf_watermark_active'] ) ) : ?>
                <div class="row">
                    <div id="watermark-settings-main-box" class="col-12 px-4 pt-5 pb-4 bg-white watermark-settings-box">
                        <form method="post" name="woow_pdf_form_watermark_format" action="options.php">
                            <div class="">
                                <?php settings_fields( 'woow_pdf_display_settings_format_watermark' ); ?>
                                <?php do_settings_sections( 'woow_pdf_display_settings_format_watermark' ); ?>
                                <table class="form-table">
                                    <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_mode' ); ?></tr>
                                </table>
                                <?php
                                    $options     = get_option( 'woow_pdf_display_settings_format_watermark' );
                                    $div_display = ( isset( $options['woow_pdf_format_watermark_mode'] ) ? $options['woow_pdf_format_watermark_mode'] : 0 );
                                ?>
                                <div class="watermark-mode" id="div-mode0" style="<?php echo ( 0 === (int) $div_display ? '' : 'display: none' ); ?>">
                                    <table class="form-table">
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_text' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_font_family' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_text_color' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_text_postion' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_text_layer' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_size' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_opacity' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_rotation' ); ?></tr>
                                    </table>
                                </div>
                                <div class="watermark-mode" id="div-mode1" style="<?php echo ( 1 === (int) $div_display ? '' : 'display: none' ); ?>">
                                    <table class="form-table">
                                    <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_image_layer' ); ?></tr>
                                        <tr><?php do_settings_fields( 'woow_pdf_display_settings_format_watermark', 'format_watermark_settings_section_image' ); ?></tr>
                                    </table>
                                </div>
                                <?php submit_button(); ?>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php endif; ?>
        
    </div>

<?php
}