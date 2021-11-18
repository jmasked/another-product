<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://greencraft.design/another-product
 * @since      1.0.0
 *
 * @package    Another_Product
 * @subpackage Another_Product/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Another_Product
 * @subpackage Another_Product/public
 * @author     Jaime Manikas
 */
class Another_Product_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/another-product-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-grid', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-grid.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/another-product-public.js', array( 'jquery' ), $this->version, false );
	}

	public function another_product() {
	  ob_start();
		global $wpdb,$product;
		if (is_product()) {
			$upload_logo = get_post_meta(get_the_ID(), 'upload_logo', true );
			$tagline_text = get_post_meta(get_the_ID(), 'tagline_text', true );
			$notice_text = get_post_meta(get_the_ID(), 'notice_text', true );
			$another_product_sku = get_post_meta(get_the_ID(), 'another_product_sku', true );
			$another_product_id=wc_get_product_id_by_sku($another_product_sku);
			$another_product_title=get_the_title($another_product_id);
			$another_product = wc_get_product($another_product_id);
			$currency_symbol=get_woocommerce_currency_symbol();
			$another_product_img=get_the_post_thumbnail_url($another_product_id);

			if ($another_product_id && $another_product_sku) {
				require_once Another_Product_DIR . 'public/partials/another-product-public-display.php';	    	
			}
	  	}
		$ReturnString = ob_get_contents(); ob_end_clean(); 
 		return $ReturnString;
	}
}
