<?php
/**
* Plugin Name: Quaderno Checkout
* Plugin URI: https://wordpress.org/plugins/quaderno-checkout
* Description: Accept payments from individual products or services from any device, and never worry about local or international taxes.
* Version: 1.9.0
* Author: Quaderno
* Author URI: http://quaderno.io
* License: GPL2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class WP_Quaderno_Checkout{
  function __construct() {
    add_action( 'admin_init', array( $this, 'quaderno_checkout_settings' ));
    add_action( 'admin_menu', array( $this, 'quaderno_checkout_add_menu' ));
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'quaderno_checkout_add_action_links' ));
    add_filter( 'plugin_row_meta', array( $this, 'quaderno_checkout_meta_links' ), 10, 2);
    
    $this::setup_constants();
    $this::includes();
  }
  
  private function setup_constants() {
    // Plugin Folder
    if ( ! defined( 'QUADERNO_PLUGIN_DIR' ) ) {
      define( 'QUADERNO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
    }
  }
  
  private function includes() {
    require_once QUADERNO_PLUGIN_DIR . 'vendor/autoload.php';
    require_once QUADERNO_PLUGIN_DIR . 'includes/shortcodes.php';
  }

  /*
  * Register settings
  */
  function quaderno_checkout_settings() {
    register_setting( 'quaderno-checkout-settings-group', 'quaderno_private_key' );
    register_setting( 'quaderno-checkout-settings-group', 'quaderno_public_key' );
  }

  /*
  * Add admin menu
  */
  function quaderno_checkout_add_menu() {
    add_options_page(
      'Quaderno Checkout', 
      'Quaderno Checkout', 
      'manage_options', 
      'quaderno-checkout-settings', 
      array(__CLASS__, 'quaderno_checkout_settings_page')
    );
  }
  
  /*
  * Actions perform on loading of menu pages
  */
  function quaderno_checkout_settings_page() {
    include('views/settings.php');
  }

  /*
  * Add action links
  */
  function quaderno_checkout_add_action_links( $links ) {
    $mylinks = array('<a href="' . admin_url( 'options-general.php?page=quaderno-checkout-settings' ) . '">Settings</a>',);
    return array_merge( $links, $mylinks ); 
  }

  /*
  * Add meta links
  */
  function quaderno_checkout_meta_links( $links, $file ) {
    $plugin = plugin_basename(__FILE__);

    // create link
    if ( $file == $plugin ) { 
      return array_merge(
        $links,
        array( '<a href="https://quadernoapp.com/signup?utm_source=wordpress&utm_campaign=checkout" target="_blank">Create a Quaderno account</a>' )
      );
    }
    return $links;
  }
}

new WP_Quaderno_Checkout();
