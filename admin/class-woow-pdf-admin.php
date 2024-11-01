<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://workforcecommerce.com
 * @since      1.0.0
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woow_Pdf
 * @subpackage Woow_Pdf/admin
 * @author     Workforce Commerce <info@workforcecommerce.com>
 */
class Woow_Pdf_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woow_Pdf_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woow_Pdf_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( $hook == 'settings_page_woow-pdf-content-setting' ) {
			
			// Add the color picker css file
			wp_enqueue_style( 'wp-color-picker' );
			
			wp_enqueue_style( 'woow-pdf-admin-boot-style', plugins_url( '/assets/bootstrap/css/bootstrap.min.css', __DIR__ ), array(), '5.3.3', 'all' );
			wp_enqueue_style( 'woow-pdf-admin-style', plugin_dir_url( __FILE__ ) . 'css/woow-pdf-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woow_Pdf_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woow_Pdf_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( $hook == 'settings_page_woow-pdf-content-setting' ) {
			
			wp_enqueue_script( 'woow-pdf-admin-boot-script', plugins_url( '/assets/bootstrap/js/bootstrap.bundle.min.js', __DIR__ ), array(), '5.3.3', true );
			wp_enqueue_script( 'woow-pdf-admin-script', plugin_dir_url( __FILE__ ) . 'js/woow-pdf-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
			wp_enqueue_media();
			wp_enqueue_script( 'woow-pdf-admin-media-selector-script', plugin_dir_url( __FILE__ ) . 'js/media-selector.js', array('jquery'), $this->version, true );
			wp_localize_script(
				'woow-pdf-admin-media-selector-script',
				'woow_pdf_admin_media_selector',
				array(
					'title' => esc_html__( 'Select an image to upload', 'woow-pdf' ),
					'button' => esc_html__( 'Use this image', 'woow-pdf' ),
					'post_id' => get_the_ID(),
					'mime_types' => array('image/png', 'image/jpeg', 'image/webp')
				)
			);
		}

	}

	/**
	 * Add Link to page settings from Plugins List Page.
	 *
	 * @since    1.0.0
	 *
	 * @param    array $actions    An array of plugin action links.
	 */
	public function add_action_links( $actions ) {
		$custom_links = array(
			'<a href="' . admin_url( 'options-general.php?page=woow-pdf-content-setting' ) . '">Settings</a>',
		);
		$actions      = array_merge( $actions, $custom_links );

		return $actions;
	}

}
