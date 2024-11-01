<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://woowpdf.com/
 * @since             1.0.0
 * @package           Woow_Pdf
 *
 * @wordpress-plugin
 * Plugin Name:       WowPDF
 * Plugin URI:        https://woowpdf.com/
 * Description:       Reduce the size of your PDF files and add watermarks as text/image effortlessly. Now, you can efficiently optimize all your PDF files and add watermark automatically, just like on woowpdf.com.
 * Version:           1.1.0
 * Requires at least: 5.3
 * Requires PHP:      7.4
 * Author:            Workforce Commerce
 * Author URI:        https://workforcecommerce.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woow-pdf
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOW_PDF_VERSION', '1.1.0' );
// wn-custom-code
define( 'WOOW_PDF_ASSETS_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );
define( 'WOOW_PDF_PLUGIN_NAME', plugin_basename( __FILE__ ) );

require __DIR__ . '/admin/woow-pdf-admin-page-settings.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woow-pdf-activator.php
 */
function woow_pdf_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woow-pdf-activator.php';
	Woow_Pdf_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woow-pdf-deactivator.php
 */
function woow_pdf_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woow-pdf-deactivator.php';
	Woow_Pdf_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'woow_pdf_activate' );
register_deactivation_hook( __FILE__, 'woow_pdf_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woow-pdf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

define( 'WOOW_PDF_API_URL', 'https://stagingapis.woowapis.online/pdftools/' );
define( 'WOOW_PDF_APP_KEY', 'urep43vrm299hboy8776cnd3lwfiax58' );
define( 'WOOW_PDF_HOST_KEY', '127.0.0.1:5000' );

function woow_pdf_run() {

	$plugin = new Woow_Pdf();
	$plugin->run();

}
woow_pdf_run();
