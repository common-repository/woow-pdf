<?php
/**
 * Main Settings Admin
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require __DIR__ . '/general-settings.php';
require __DIR__ . '/watermark-settings.php';
require __DIR__ . '/compress-settings.php';
require __DIR__ . '/partials/woow-pdf-settings-display.php';
require __DIR__ . '/functions-processed-files.php';
require __DIR__ . '/functions-watermark.php';
require __DIR__ . '/functions-compress.php';
require __DIR__ . '/functions-watermark-compress.php';

/**
 * Add Menu Page to Dashboard.
 *
 * @since    1.0.0
 */
function woow_pdf_menu() {

	// Add page menu to WordPress dashboard
    add_submenu_page(
        'options-general.php',             // Register this submenu with the menu defined above
        'WoowPDF Settings',                // The text to the display in the browser when this menu item is active
        'WoowPDF',                         // The text for this menu item
        'manage_options',                  // Which type of users can see this menu
        'woow-pdf-content-setting',        // The unique ID - the slug - for this menu item
        'woow_pdf_content_page_setting'    // The function used to render the menu for this page to the screen
    );
}
add_action( 'admin_menu', 'woow_pdf_menu' );