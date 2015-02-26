<?php
/*
Plugin Name: Gabfire Login Limits Beta
plugin URI:
Description:
version: 0.5
Author: Gabfire Themes
Author URI: http://gabfirethemes.com
License: GPL2
*/

/**
 * Global Definitions
 */

/* Plugin Name */

if (!defined('GABFIRE_LOGIN_LIMITS_PLUGIN_NAME'))
    define('GABFIRE_LOGIN_LIMITS_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

/* Plugin directory */

if (!defined('GABFIRE_LOGIN_LIMITS_PLUGIN_DIR'))
    define('GABFIRE_LOGIN_LIMITS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . GABFIRE_LOGIN_LIMITS_PLUGIN_NAME);

/* Plugin url */

if (!defined('GABFIRE_LOGIN_LIMITS_PLUGIN_URL'))
    define('GABFIRE_LOGIN_LIMITS_PLUGIN_URL', WP_PLUGIN_URL . '/' . GABFIRE_LOGIN_LIMITS_PLUGIN_NAME);

/* Plugin verison */

if (!defined('GABFIRE_LOGIN_LIMITS_VERSION_NUM'))
    define('GABFIRE_LOGIN_LIMITS_VERSION_NUM', '0.5.0');


/**
 * Activatation / Deactivation
 */

register_activation_hook( __FILE__, array('GabfireLoginLimits', 'register_activation'));

/**
 * Hooks / Filter
 */

add_action('init', array('GabfireLoginLimits', 'load_textdomain'));
add_action('admin_menu', array('GabfireLoginLimits', 'gabfire_menu_page'));

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", array('GabfireLoginLimits', 'gabfire_settings_link'));

/**
 *  GabfireLoginLimits main class
 *
 * @since 1.0.0
 * @using Wordpress 3.8
 */

class GabfireLoginLimits {

	/* Properties */

	public static $text_domain = 'gabfire-login-limits';

	static $prefix = 'gabfire_login_limits_';

	private static $settings_page = 'gabfire-login-limits-admin-menu-settings';

	public static $default = array(
		'login_attempt_limit'	=> '-1',
		'cache_limit'			=> '60',
		'cache_wait_limit'		=> '300'
	);

	/**
	 * Load the text domain
	 *
	 * @since 1.0.0
	 */
	static function load_textdomain() {
		load_plugin_textdomain(self::$text_domain, false, GABFIRE_LOGIN_LIMITS_PLUGIN_DIR . '/languages');
	}

	/**
	 * Hooks to 'register_activation_hook'
	 *
	 * @since 1.0.0
	 */
	static function register_activation() {

		/* Check if multisite, if so then save as site option */

		if (function_exists('is_multisite') && is_multisite()) {
			add_site_option('gabfire_login_limits_version', GABFIRE_LOGIN_LIMITS_VERSION_NUM);
		} else {
			add_option('gabfire_login_limits_version', GABFIRE_LOGIN_LIMITS_VERSION_NUM);
		}
	}

	/**
	 * Hooks to 'plugin_action_links_' filter
	 *
	 * @since 1.0.0
	 */
	static function gabfire_settings_link($links) {
		$settings_link = '<a href="options-general.php?page=' . self::$settings_page . '">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Hooks to 'admin_menu'
	 *
	 * @since 1.0.0
	 */
	static function gabfire_menu_page() {

		/* Add the menu Page */

		$settings_page_load = add_submenu_page(
			'options-general.php',
			__('Gabfire Login Limits', self::$text_domain),							// Page Title
			__('Gabfire Login Limits', self::$text_domain), 							// Menu Name
	    	'manage_options', 											// Capabilities
	    	self::$settings_page, 										// slug
	    	array('GabfireLoginLimits', 'gabfire_admin_settings')	// Callback function
	    );
	    add_action("admin_print_scripts-$settings_page_load", array('GabfireLoginLimits', 'gabfire_include_admin_scripts'));
	}

	/**
	 * Hooks to 'admin_print_scripts-$page'
	 *
	 * @since 1.0.0
	 */
	static function gabfire_include_admin_scripts() {

		/* CSS */

		wp_register_style('gabfire_login_limits_admin_css', plugins_url('/css/dashboard.css', __FILE__));
		wp_enqueue_style('gabfire_login_limits_admin_css');
	}

	/**
	 * Displays the HTML for the 'gabfire-login-limits-admin-menu-settings' admin page
	 *
	 * @since 1.0.0
	 */
	static function gabfire_admin_settings() {

		if (function_exists('is_multisite') && is_multisite()) {
			$settings = get_site_option('gabfire_login_limits_settings');
		} else {
			$settings = get_option('gabfire_login_limits_settings');
		}

		/* Default values */

		if ($settings === false) {
			$settings = self::$default;
		}

		/* Save data nd check nonce */

		if (isset($_POST['submit']) && check_admin_referer('gabfire_login_limits_admin_settings')) {

			$settings = get_option('gabfire_login_limits_settings');

			/* Default values */

			if ($settings === false) {
				$settings = self::$default;
			}

			$settings = array(
				'login_attempt_limit'	=> stripcslashes(sanitize_text_field($_POST['gabfire_settings_login_attempt_limit'])),
				'cache_limit'			=> stripcslashes(sanitize_text_field($_POST['gabfire_settings_cache_limit'])),
				'cache_wait_limit'		=> stripcslashes(sanitize_text_field($_POST['gabfire_settings_cache_wait_limit']))
			);

			if (function_exists('is_multisite') && is_multisite()) {
				update_site_option('gabfire_login_limits_settings', $settings);
			} else {
				update_option('gabfire_login_limits_settings', $settings);
			}
		}

		require('admin/dashboard.php');
	}


	/**
	 * Get IP address from user
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static function getIP() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}
}

if (!function_exists('wp_authenticate')):
/**
 * wp_authenticate function.
 *
 * @access public
 * @param mixed $username
 * @param mixed $password
 * @return void
 */
function wp_authenticate($username, $password) {

	wp_enqueue_script(GabfireLoginLimits::$prefix . 'js', plugins_url('js/gab_ll_login.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-effects-shake'));

	$username = sanitize_user($username);
    $password = trim($password);

    $attempt_transient = 'gabfire_login_limit_' . GabfireLoginLimits::getIP();
	$wait_transient = 'gabfire_login_wait_limit_' . GabfireLoginLimits::getIP();

	$limit = get_transient($attempt_transient);
	$wait = get_transient($wait_transient);

	if (function_exists('is_multisite') && is_multisite()) {
		$settings = get_site_option('gabfire_login_limits_settings');
	} else {
		$settings = get_option('gabfire_login_limits_settings');
	}

	if ($settings === false) {
		$settings = GabfireLoginLimits::$default;
	}

	// Waiting for next time to login

	if ($wait !== false) {
		return new WP_Error('login_attempt_limit', __( "You have reached your login attempt limit: $settings[login_attempt_limit].  Try again in $settings[cache_wait_limit] seconds.", GabfireLoginLimits::$text_domain));
	} else {


		/**
		 * user
		 *
		 * (default value: apply_filters( 'authenticate', null, $username, $password ))
		 *
		 * @var string
		 * @access public
		 */
		$user = apply_filters( 'authenticate', null, $username, $password );

		$ignore_codes = array('empty_username', 'empty_password');

		if (is_wp_error($user) && !in_array($user->get_error_code(), $ignore_codes) ) {

			// First time login attempt failed within cached time

			if ($limit === false) {
			  	set_transient($attempt_transient, 1, $settings['cache_limit']);

			  	$attempts = $settings['login_attempt_limit'] - 1;

			  	return new WP_Error('login_attempt_limit', __("Invalid login credentials.  You have $attempts more attempts.", GabfireLoginLimits::$text_domain));
			}

			// Has failed login before within cached time

			else {

				// Has not exceeded limit

				if ($settings['login_attempt_limit'] > ($limit + 1)) {

					$limit++;

					set_transient($attempt_transient, $limit, $settings['cache_limit']);

					$attempts = $settings['login_attempt_limit'] - $limit;

					return new WP_Error('login_attempt_limit', __("Invalid login credentials.  You have $attempts more attempts.", GabfireLoginLimits::$text_domain));
				}

				// Exceeded limit

				else {
					set_transient($wait_transient, GabfireLoginLimits::getIP(), $settings['cache_wait_limit']);

					$limit++;

					return new WP_Error('login_attempt_limit', __( "You have reached your login attempt limit: $limit.  Try again in $settings[cache_wait_limit] seconds.", GabfireLoginLimits::$text_domain));
				}
			}
		}
	}

	return $user;
}
endif;
?>