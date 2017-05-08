<?php
/**
 * Plugin Name:     qTranslate-Next
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Valentyn Riaboshtan
 * Author URI:      YOUR SITE HERE
 * Text Domain:     qtranslate-next
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package  Qtranslate_Next
 * @category Core
 * @author   Valentyn Riaboshtan
 */

use QtNext\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/lib/autoloader.php';
require_once __DIR__ . '/vendor/autoload.php';

if ( WP_DEBUG ) {
	if ( class_exists( 'Kint' ) ) {
		Kint::$enabled_mode = false;
	}

	require_once 'debug.php';
}


if ( ! class_exists( 'Qtranslate_Next' ) ) :

	/**
	 * Main Qtranslate_Next Class.
	 *
	 * @class   QtranslateNext
	 * @version 1.0.0
	 */
	final class Qtranslate_Next {

		/**
		 * QtranslateNext version.
		 *
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * The single instance of the class.
		 *
		 * @var Qtranslate_Next
		 * @since 2.1
		 */
		protected static $_instance = null;

		/**
		 * Order factory instance.
		 *
		 * @var Core\QtN_Config
		 */
		public $setup = null;

		/**
		 * Main Qtranslate_Next Instance.
		 *
		 * Ensures only one instance of WooCommerce is loaded or can be loaded.
		 *
		 * @static
		 * @see   QN()
		 * @return Qtranslate_Next - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 * @since 2.1
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 * @since 2.1
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );
		}

		/**
		 * WooCommerce Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'qtn_loaded' );
		}

		/**
		 * Hook into actions and filters.
		 * @since  2.3
		 */
		private function init_hooks() {
			add_action( 'init', array( $this, 'init' ), 0 );
		}

		/**
		 * Define WC Constants.
		 */
		private function define_constants() {
			$this->define( 'QTN_PLUGIN_FILE', __FILE__ );
			$this->define( 'QTN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'QTN_VERSION', $this->version );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string      $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin, ajax, cron or frontend.
		 *
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
				default:
					return false;
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {
//			include_once( 'core/class-wc-autoloader.php' );
			include_once( 'core/qtn-core-functions.php' );
//			include_once( 'core/wc-widget-functions.php' );
//			include_once( 'core/wc-webhook-functions.php' );
//			include_once( 'core/class-wc-install.php' );
//			include_once( 'core/class-wc-geolocation.php' );
//			include_once( 'core/class-wc-download-handler.php' );
//			include_once( 'core/class-wc-comments.php' );
//			include_once( 'core/class-wc-post-data.php' );
//			include_once( 'core/class-wc-ajax.php' );

			new Core\QtN_Posts();

			if ( $this->is_request( 'admin' ) ) {
				new QtNext\Core\Admin\QtN_Admin;
			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}

			if ( $this->is_request( 'frontend' ) || $this->is_request( 'cron' ) ) {
//				include_once( 'core/class-wc-session-handler.php' );
			}

//			include_once( 'core/class-wc-query.php' ); // The main query class
//			include_once( 'core/class-wc-api.php' ); // API Class
//			include_once( 'core/class-wc-auth.php' ); // Auth Class
//			include_once( 'core/class-wc-post-types.php' ); // Registers post types
//			include_once( 'core/abstracts/abstract-wc-data.php' );                 // WC_Data for CRUD
//			include_once( 'core/abstracts/abstract-wc-payment-token.php' ); // Payment Tokens
//			include_once( 'core/abstracts/abstract-wc-product.php' ); // Products
//			include_once( 'core/abstracts/abstract-wc-order.php' ); // Orders
//			include_once( 'core/abstracts/abstract-wc-settings-api.php' ); // Settings API (for gateways, shipping, and integrations)
//			include_once( 'core/abstracts/abstract-wc-shipping-method.php' ); // A Shipping method
//			include_once( 'core/abstracts/abstract-wc-payment-gateway.php' ); // A Payment gateway
//			include_once( 'core/abstracts/abstract-wc-integration.php' ); // An integration with a service
//			include_once( 'core/class-wc-product-factory.php' ); // Product factory
//			include_once( 'core/class-wc-payment-tokens.php' ); // Payment tokens controller
//			include_once( 'core/gateways/class-wc-payment-gateway-cc.php' ); // CC Payment Gateway
//			include_once( 'core/gateways/class-wc-payment-gateway-echeck.php' ); // eCheck Payment Gateway
//			include_once( 'core/class-wc-countries.php' ); // Defines countries and states
//			include_once( 'core/class-wc-integrations.php' ); // Loads integrations
//			include_once( 'core/class-wc-cache-helper.php' ); // Cache Helper
//			include_once( 'core/class-wc-https.php' ); // https Helper

			if ( defined( 'WP_CLI' ) && WP_CLI ) {
//				include_once( 'core/class-wc-cli.php' );
			}

			global $qtn_config;
			$qtn_config = new Core\QtN_Config();
//			$this->api   = new WC_API();
		}

		/**
		 * Include required frontend files.
		 */
		public function frontend_includes() {
//			include_once( 'core/wc-cart-functions.php' );
//			include_once( 'core/wc-notice-functions.php' );
//			include_once( 'core/wc-template-hooks.php' );
//			include_once( 'core/class-wc-template-loader.php' );                // Template Loader
//			include_once( 'core/class-wc-frontend-scripts.php' );               // Frontend Scripts
//			include_once( 'core/class-wc-form-handler.php' );                   // Form Handlers
		}

		/**
		 * Init WooCommerce when WordPress Initialises.
		 */
		public function init() {
			// Before init action.
			do_action( 'before_qtn_init' );

			// Set up localisation.
			$this->load_plugin_textdomain();

			// Load class instances.
//			$this->product_factory = new WC_Product_Factory();                      // Product Factory to create new product instances
//			$this->order_factory   = new WC_Order_Factory();                        // Order Factory to create new order instances
//			$this->countries       = new WC_Countries();                            // Countries class
//			$this->integrations    = new WC_Integrations();                         // Integrations class

			// Session class, handles session data for users - can be overwritten if custom handler is needed.
			if ( $this->is_request( 'frontend' ) || $this->is_request( 'cron' ) ) {
//				$session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
//				$this->session = new $session_class();
			}

			// Classes/actions loaded for the frontend and for ajax requests.
			if ( $this->is_request( 'frontend' ) ) {
//				$this->cart     = new WC_Cart();                                    // Cart class, stores the cart contents
//				$this->customer = new WC_Customer();                                // Customer class, handles data such as customer location
			}

			// Init action.
			do_action( 'qtn_init' );
		}

		/**
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'qtranslate-next', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Get Ajax URL.
		 * @return string
		 */
		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}
	}

endif;

/*add_filter('posts_where', function ($where, $query) {
	if (isset($query->query)) {
		global $wpdb;
		$lang = $query->query['lang'];
		$like = '%{:' . $wpdb->esc_like($lang) . '}%';
		$where .= $wpdb->prepare( " AND ({$wpdb->posts}.post_title LIKE %s OR {$wpdb->posts}.post_content LIKE %s)", $like, $like );
	}
	return $where;
}, 10, 2);*/

function QN() {
	return Qtranslate_Next::instance();
}

QN();
