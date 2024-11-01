<?php
/**
 * Watermark Settings
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
function woow_pdf_initialize_options_watermark() {

    if ( false === get_option( 'woow_pdf_display_settings_watermark' ) ) {
        add_option( 'woow_pdf_display_settings_watermark' );
    }

    add_settings_section(
        'watermark_settings_section',
        '',
        'woow_pdf_watermark_options_callback',
        'woow_pdf_display_settings_watermark'
    );

    add_settings_field(
        'woow_pdf_watermark_active',
        __( 'Enable Watermark PDF:', 'woow-pdf' ),
        'woow_pdf_watermark_active_callback',
        'woow_pdf_display_settings_watermark',
        'watermark_settings_section',
        array(
            __( 'Activate this setting to add Watermark on PDF files.', 'woow-pdf' ),
        )
    );

    add_settings_field(
        'woow_pdf_watermark_auto',
        __( 'Auto Watermark:', 'woow-pdf' ),
        'woow_pdf_watermark_auto_callback',
        'woow_pdf_display_settings_watermark',
        'watermark_settings_section',
        array(
            __( 'Auto Watermark on newly uploaded PDF files.', 'woow-pdf' ),
        )
    );

    register_setting(
        'woow_pdf_display_settings_watermark',
        'woow_pdf_display_settings_watermark'
    );
}
add_action( 'admin_init', 'woow_pdf_initialize_options_watermark' );

/**
 * Options Callback.
 *
 * @since    1.0.0
 */
function woow_pdf_watermark_options_callback() {
    echo '<h5 class="mb-4">' . esc_html( __( 'Adjust your PDF watermark settings:', 'woow-pdf' ) ) . '</h5>';
}

/**
 * Active Watermark Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_watermark_active_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_watermark' );
    $checked_watermark = isset( $options['woow_pdf_watermark_active'] ) ? checked( 1, $options['woow_pdf_watermark_active'], false ) : '';
	?>

	<input type="checkbox" id="woow_pdf_watermark_active" name="woow_pdf_display_settings_watermark[woow_pdf_watermark_active]" value="1" <?php echo esc_attr( $checked_watermark ); ?>>
	<label for="woow_pdf_watermark_active"><?php echo esc_html( $args[0] ); ?></label>

	<?php
}

/**
 * Enable Auto Watermark Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_watermark_auto_callback( $args ) {
	?>
	<span class="dashicons dashicons-yes woow-pdf-tick-icon"></span>
	<label for="woow_pdf_watermark_auto"><?php echo esc_html( $args[0] ); ?></label>

	<?php
}

/**
 * Initialize Options for Watermark the admin area.
 *
 * @since    1.0.0
 */
function woow_pdf_initialize_options_format_watermark() {

    if ( ! empty( $_SERVER['PHP_SELF'] ) && 'options-general.php' === basename( sanitize_url( wp_unslash( $_SERVER['PHP_SELF'] ) ) ) ) {
		wp_enqueue_media(); }

    if ( false === get_option( 'woow_pdf_display_settings_format_watermark' ) ) {
        add_option( 'woow_pdf_display_settings_format_watermark' );
    }

    add_settings_section(
        'format_watermark_settings_section',
        '',
        'woow_pdf_format_watermark_options_callback',
        'woow_pdf_display_settings_format_watermark'
    );

    add_settings_field(
        'woow_pdf_format_watermark_mode',
        __( 'Choose Watermark Style', 'woow-pdf' ),
        'woow_pdf_format_watermark_mode_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_mode',
        array(
            'Text',
            'Image',
        )
    );

    add_settings_field(
        'woow_pdf_format_watermark_text',
        __( 'Watermark Text', 'woow-pdf' ),
        'woow_pdf_format_watermark_text_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_text'
    );

    add_settings_field(
        'woow_pdf_format_watermark_text_size',
        __( 'Watermark Text Size', 'woow-pdf' ),
        'woow_pdf_format_watermark_text_size_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_size',
        array(
            __( '8px - 100px', 'woow-pdf' ),
        )
    );

    add_settings_field(
        'woow_pdf_format_watermark_font_family',
        __( 'Watermark Font Family', 'woow-pdf' ),
        'woow_pdf_format_watermark_font_family_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_font_family',
        array(
            'Helvetica',
            'Helvetica-Bold',
            'Helvetica-Oblique',
            'Helvetica-BoldOblique',
            'Times-Roman',
            'Times-Bold',
            'Times-Italic',
            'Times-BoldItalic',
            'Courier',
            'Courier-Bold',
            'Courier-Oblique',
            'Courier-BoldOblique',
            'Symbol',
            'ZapfDingbats',
        )
    );

    add_settings_field(
        'woow_pdf_format_watermark_text_color',
        __( 'Watermark Text Color', 'woow-pdf' ),
        'woow_pdf_format_watermark_text_color_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_text_color'
    );

    add_settings_field(
        'woow_pdf_format_watermark_image',
        __( 'Watermark image', 'woow-pdf' ),
        'woow_pdf_format_watermark_image_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_image'
    );

    add_settings_field(
        'woow_pdf_format_watermark_image_layer',
        __( 'Image Placement', 'woow-pdf' ),
        'woow_pdf_format_watermark_image_layer_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_image_layer',
        array(
            'Forward Text',
            'Backward Text',
        )
    );

    add_settings_field(
        'woow_pdf_format_watermark_text_postion',
        __( 'Watermark Text Position', 'woow-pdf' ),
        'woow_pdf_format_watermark_text_postion_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_text_postion',
        array(
            'Center Center',
            'Top Center',
            'Bottom Center',
            'Mosaic',
        )
    );

    add_settings_field(
        'woow_pdf_format_watermark_text_layer',
        __( 'Watermark Text Layer', 'woow-pdf' ),
        'woow_pdf_format_watermark_text_layer_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_text_layer',
        array(
            'Over',
            'Below',
        )
    );

    add_settings_field(
        'woow_pdf_format_watermark_opacity',
        __( 'Watermark Opacity', 'woow-pdf' ),
        'woow_pdf_format_watermark_opacity_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_opacity',
        array(
            __( '10% - 100%', 'woow-pdf' ),
        )
    );

    add_settings_field(
        'woow_pdf_format_watermark_rotation',
        __( 'Watermark Rotation', 'woow-pdf' ),
        'woow_pdf_format_watermark_rotation_callback',
        'woow_pdf_display_settings_format_watermark',
        'format_watermark_settings_section_rotation',
        array(
            __( '0° - 360°', 'woow-pdf' ),
        )
    );

    register_setting(
        'woow_pdf_display_settings_format_watermark',
        'woow_pdf_display_settings_format_watermark'
    );
}
add_action( 'admin_init', 'woow_pdf_initialize_options_format_watermark' );

/**
 * Watermark Options Callback.
 *
 * @since    1.0.0
 */
function woow_pdf_format_watermark_options_callback() {
    echo '<h5 class="mb-4">' . esc_html( __( 'Set up your Watermark format:', 'woow-pdf' ) ) . '</h5>';
}

/**
 * Watermark Content Text Callback (Mode Text).
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_text_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $text_value = isset( $options['woow_pdf_format_watermark_text'] ) ? $options['woow_pdf_format_watermark_text'] : get_bloginfo();
	?>

	<input type="text" id="woow_pdf_format_watermark_text" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text]" value="<?php echo esc_attr( $text_value ); ?>">
	<span id="woowpdf-text-required" class="woowpdf-field-required" style="display:none;">Text is required</span>

	<?php
}

/**
 * Watermark Font Family Callback (Mode Text).
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_font_family_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $font_family = isset( $options['woow_pdf_format_watermark_font_family'] ) ? $options['woow_pdf_format_watermark_font_family'] : '';
	?>

	<select id="woow_pdf_format_watermark_font_family" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_font_family]">
		<option value="<?php echo esc_attr( $args[0] ); ?>" <?php selected( $font_family, $args[0] ); ?>>Helvetica</option>
		<option value="<?php echo esc_attr( $args[1] ); ?>" <?php selected( $font_family, $args[1] ); ?>>Helvetica-Bold</option>
		<option value="<?php echo esc_attr( $args[2] ); ?>" <?php selected( $font_family, $args[2] ); ?>>Helvetica-Oblique</option>
		<option value="<?php echo esc_attr( $args[3] ); ?>" <?php selected( $font_family, $args[3] ); ?>>Helvetica-BoldOblique</option>
		<option value="<?php echo esc_attr( $args[4] ); ?>" <?php selected( $font_family, $args[4] ); ?>>Times-Roman</option>
		<option value="<?php echo esc_attr( $args[5] ); ?>" <?php selected( $font_family, $args[5] ); ?>>Times-Bold</option>
		<option value="<?php echo esc_attr( $args[6] ); ?>" <?php selected( $font_family, $args[6] ); ?>>Times-Italic</option>
		<option value="<?php echo esc_attr( $args[7] ); ?>" <?php selected( $font_family, $args[7] ); ?>>Times-BoldItalic</option>
		<option value="<?php echo esc_attr( $args[8] ); ?>" <?php selected( $font_family, $args[8] ); ?>>Courier</option>
		<option value="<?php echo esc_attr( $args[9] ); ?>" <?php selected( $font_family, $args[9] ); ?>>Courier-Bold</option>
		<option value="<?php echo esc_attr( $args[10] ); ?>" <?php selected( $font_family, $args[10] ); ?>>Courier-Oblique</option>
		<option value="<?php echo esc_attr( $args[11] ); ?>" <?php selected( $font_family, $args[11] ); ?>>Courier-BoldOblique</option>
		<option value="<?php echo esc_attr( $args[12] ); ?>" <?php selected( $font_family, $args[12] ); ?>>Symbol</option>
		<option value="<?php echo esc_attr( $args[13] ); ?>" <?php selected( $font_family, $args[13] ); ?>>ZapfDingbats</option>
	</select>

	<?php
}

/**
 * Watermark Text Color Callback (Mode Text).
 *
 * @since    1.0.0
 */
function woow_pdf_format_watermark_text_color_callback() {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $default_color = '#673ab7';
	$selected_color = isset( $options['woow_pdf_format_watermark_text_color'] ) ? $options['woow_pdf_format_watermark_text_color'] : $default_color;
	?>

	<input type="text" class="color-field" id="woow_pdf_format_watermark_text_color" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_color]" value="<?php echo esc_attr( $selected_color ); ?>" required>
	<span id="woowpdf-color-required" class="woowpdf-field-required" style="display:none;">Color is required</span>

	<?php
}

/**
 * Watermark Text Size Callback (Mode Text).
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_text_size_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $text_size = isset( $options['woow_pdf_format_watermark_text_size'] ) ? $options['woow_pdf_format_watermark_text_size'] : 60;
	?>

	<input type="number" id="woow_pdf_format_watermark_text_size" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_size]" min="8" max="100" value="<?php echo esc_attr( $text_size ); ?>">
	<label for="woow_pdf_format_watermark_text_size" class="ms-1"><?php echo esc_html( $args[0] ); ?></label>
	<span id="woowpdf-size-required" class="woowpdf-field-required" style="display:none;"><?php esc_html_e( 'Size is required', 'woow-pdf' ); ?></span>

	<?php
}

/**
 * Watermark text_postion Position Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_text_postion_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $checked_center   = isset( $options['woow_pdf_format_watermark_text_postion'] ) ? checked( 'center_center', $options['woow_pdf_format_watermark_text_postion'], false ) : 'checked="checked"';
	$checked_top      = isset( $options['woow_pdf_format_watermark_text_postion'] ) ? checked( 'top_center', $options['woow_pdf_format_watermark_text_postion'], false ) : '';
	$checked_bottom   = isset( $options['woow_pdf_format_watermark_text_postion'] ) ? checked( 'bottom_center', $options['woow_pdf_format_watermark_text_postion'], false ) : '';
	$checked_mosaic   = isset( $options['woow_pdf_format_watermark_text_postion'] ) ? checked( 'mosaic', $options['woow_pdf_format_watermark_text_postion'], false ) : '';
	?>

	<input type="radio" id="woow_pdf_format_watermark_text_postion_center" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_postion]" value="center_center" <?php echo esc_attr( $checked_center ); ?> style="margin-bottom: 6px"><label for="woow_pdf_format_watermark_text_postion_center" style="margin-bottom: 6px"> <?php echo esc_html( $args[0] ); ?></label><br/>
	<input type="radio" id="woow_pdf_format_watermark_text_postion_top" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_postion]" value="top_center" <?php echo esc_attr( $checked_top ); ?> style="margin-bottom: 6px"><label for="woow_pdf_format_watermark_text_postion_top" style="margin-bottom: 6px"> <?php echo esc_html( $args[1] ); ?></label><br/>
	<input type="radio" id="woow_pdf_format_watermark_text_postion_bottom" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_postion]" value="bottom_center" <?php echo esc_attr( $checked_bottom ); ?> style="margin-bottom: 6px"><label for="woow_pdf_format_watermark_text_postion_bottom" style="margin-bottom: 6px"> <?php echo esc_html( $args[2] ); ?></label><br/>
	<input type="radio" id="woow_pdf_format_watermark_text_postion_mosaic" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_postion]" value="mosaic" <?php echo esc_attr( $checked_mosaic ); ?> style="margin-bottom: 6px"><label for="woow_pdf_format_watermark_text_postion_mosaic" style="margin-bottom: 6px"> <?php echo esc_html( $args[3] ); ?></label>

	<?php
}

/**
 * Watermark text_layer Layer Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_text_layer_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $checked_over  = isset( $options['woow_pdf_format_watermark_text_layer'] ) ? checked( 'over', $options['woow_pdf_format_watermark_text_layer'], false ) : '';
	$checked_below = isset( $options['woow_pdf_format_watermark_text_layer'] ) ? checked( 'below', $options['woow_pdf_format_watermark_text_layer'], false ) : 'checked="checked"';
	?>

	<input type="radio" id="woow_pdf_format_watermark_text_layer_over" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_layer]" value="over" <?php echo esc_attr( $checked_over ); ?> style="margin-bottom: 6px">
	<label for="woow_pdf_format_watermark_text_layer_over" style="margin-bottom: 6px"><?php echo esc_html( $args[0] ); ?></label><br/>
	<input type="radio" id="woow_pdf_format_watermark_text_layer_below" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_text_layer]" value="below" <?php echo esc_attr( $checked_below ); ?> style="margin-bottom: 6px">
	<label for="woow_pdf_format_watermark_text_layer_below" style="margin-bottom: 6px"><?php echo esc_html( $args[1] ); ?></label>

	<?php
}

/**
 * Watermark Opacity Callback (Mode Image).
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_opacity_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $opacity_value = isset( $options['woow_pdf_format_watermark_opacity'] ) ? $options['woow_pdf_format_watermark_opacity'] : '40';
	?>

	<input type="number" id="woow_pdf_format_watermark_opacity" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_opacity]" min="10" max="100" step="10" value="<?php echo esc_attr( $opacity_value ); ?>">
	<label for="woow_pdf_format_watermark_opacity" class="ms-1"><?php echo esc_html( $args[0] ); ?></label>
	<span id="woowpdf-opacity-required" class="woowpdf-field-required" style="display:none;">Opacity is required</span>

	<?php
}

/**
 * Watermark Rotation Callback (Mode Image).
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_rotation_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $rotation_value = isset( $options['woow_pdf_format_watermark_rotation'] ) ? $options['woow_pdf_format_watermark_rotation'] : '0';
	?>

	<input type="number" id="woow_pdf_format_watermark_rotation" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_rotation]" min="0" max="360" step="5" value="<?php echo esc_attr( $rotation_value ); ?>">
	<label for="woow_pdf_format_watermark_rotation" class="ms-1"><?php echo esc_html( $args[0] ); ?></label>
	<span id="woowpdf-rotation-required" class="woowpdf-field-required" style="display:none;">Rotation is required</span>

	<?php
}

/**
 * Watermark Select Mode Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_mode_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $checked_text  = isset( $options['woow_pdf_format_watermark_mode'] ) ? checked( 0, $options['woow_pdf_format_watermark_mode'], false ) : 'checked="checked"';
	$checked_image = isset( $options['woow_pdf_format_watermark_mode'] ) ? checked( 1, $options['woow_pdf_format_watermark_mode'], false ) : '';
	?>

	<input type="radio" id="woow_pdf_format_watermark_mode_text" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_mode]" value="0" <?php echo esc_attr( $checked_text ); ?>>
	<label for="woow_pdf_format_watermark_mode_text" style="margin-right: 14px;"><?php echo esc_html( $args[0] ); ?></label>
	<input type="radio" id="woow_pdf_format_watermark_mode_image" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_mode]" value="1" <?php echo esc_attr( $checked_image ); ?>>
	<label for="woow_pdf_format_watermark_mode_image"><?php echo esc_html( $args[1] ); ?></label>

	<?php
}

/**
 * Watermark Upload Image Callback (Mode Image).
 *
 * @since    1.0.0
 */
function woow_pdf_format_watermark_image_callback() {
    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $image_value = ( isset( $options['woow_pdf_format_watermark_image'] ) && ! empty( $options['woow_pdf_format_watermark_image'] ) ) ? $options['woow_pdf_format_watermark_image'] : '';
	?>

	<div class="image-preview-wrapper"><?php 
	
	if ( isset( $options['woow_pdf_format_watermark_image'] ) && ! empty( wp_get_attachment_url($options['woow_pdf_format_watermark_image']) ) ) {
		echo '<img id="image-preview" src="' . esc_url( wp_get_attachment_url( $options['woow_pdf_format_watermark_image'] ) ) . '" width="140" height="auto" alt="watermark">';
	} else {
		echo '<img id="image-preview" width="140" height="auto" alt="image not found">';
	}
	
	?></div>
	<p id="wn-image-accept"><?php echo esc_html( __( 'Allowed File(s): .png, .jpg, .jpeg, .webp', 'woow-pdf' ) ); ?></p>
	<input id="upload_image_button" type="button" class="button" value="<?php esc_attr_e( 'Upload image', 'woow-pdf' ); ?>" />
	<input type="hidden" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_image]" id="woow_pdf_format_watermark_image" value="<?php echo esc_attr( $image_value ); ?>" />
	<input class="button-primary" type="submit" name="submit_image_selector" value="<?php esc_attr_e( 'Save', 'woow-pdf' ); ?>" />

	<?php
}

/**
 * Watermark image_layer Layer Callback.
 *
 * @since    1.0.0
 * @param    array $args    Arguments options.
 */
function woow_pdf_format_watermark_image_layer_callback( $args ) {

    $options = get_option( 'woow_pdf_display_settings_format_watermark' );
    $checked_forward = isset( $options['woow_pdf_format_watermark_image_layer'] ) ? checked( 'forward_text', $options['woow_pdf_format_watermark_image_layer'], false ) : '';
	$checked_backward = isset( $options['woow_pdf_format_watermark_image_layer'] ) ? checked( 'backward_text', $options['woow_pdf_format_watermark_image_layer'], false ) : 'checked="checked"';
	?>

	<input type="radio" id="woow_pdf_format_watermark_image_layer_forward_text" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_image_layer]" value="forward_text" <?php echo esc_attr( $checked_forward ); ?> style="margin-bottom: 6px">
	<label for="woow_pdf_format_watermark_image_layer_forward_text" style="margin-bottom: 6px"><?php echo esc_html( $args[0] ); ?></label><br/>

	<input type="radio" id="woow_pdf_format_watermark_image_layer_backward_text" name="woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_image_layer]" value="backward_text" <?php echo esc_attr( $checked_backward ); ?> style="margin-bottom: 6px">
	<label for="woow_pdf_format_watermark_image_layer_backward_text" style="margin-bottom: 6px"><?php echo esc_html( $args[1] ); ?></label>

	<?php
}

/**
 * Watermark Selector Print Callback.
 *
 * @since    1.0.0
 */
function woow_pdf_media_selector_print_scripts() {
    $options                     = get_option( 'woow_pdf_display_settings_format_watermark' );
    $my_saved_attachment_post_id = isset( $options['woow_pdf_format_watermark_image'] ) && '' !== $options['woow_pdf_format_watermark_image'] ? $options['woow_pdf_format_watermark_image'] : 0;

    ?>
    
    <?php
}
add_action( 'admin_footer', 'woow_pdf_media_selector_print_scripts' );