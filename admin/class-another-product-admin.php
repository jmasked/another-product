<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://greencraft.design/another-product
 * @since      1.0.0
 *
 * @package    Another_Product
 * @subpackage Another_Product/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Another_Product
 * @subpackage Another_Product/admin
 * @author     Jaime Manikas
 */
class Another_Product_Admin {

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
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/another-product-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-custom.css', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-custom.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-grid', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-grid.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/another-product-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('cn-custom.js', plugin_dir_url( __FILE__ ) . '../cn_package/js/cn-custom.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'cn-custom.js','cn_plugin_vars', array('ajaxurl' => admin_url('admin-ajax.php'),'plugin_url'=>Another_Product_URI));
	}

	public function post_meta_box() {
	    add_meta_box('post_meta_box',__( 'Another Product', $this->plugin_name ),array($this,'post_meta_box_content') ,'product','normal','low');
	}
	public function post_meta_box_content( $post ) {
		wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_box_content_nonce' );
		$post->ID;
		$upload_logo = get_post_meta($post->ID, 'upload_logo', true );
		$tagline_text = get_post_meta($post->ID, 'tagline_text', true );
		$notice_text = get_post_meta($post->ID, 'notice_text', true );
		$another_product_sku = get_post_meta($post->ID, 'another_product_sku', true );
		
		
	  ?>
	  	<div class="cn-form-group mb-2">
		  	<div class="row">
				<div class="cn_col-md-12">
			        <label class="control-label" for="name">Product SKU:</label>
				    <div class="cn_col-md-12 p-0">
				    	<input type="text" name="another_product_sku" value="<?php echo $another_product_sku; ?>" placeholder="Product SKU" class="cn-form-control">
				    </div>
				</div>
			</div>
		</div>
		<div class="cn-form-group mb-2">
		  	<div class="row">
					<div class="cn_col-md-12">
			        	<label class="control-label" for="name">Upload Logo:</label>
				        <div class="cn_col-md-12 p-0">
				          <input id="upload_logo" type="text" name="upload_logo" value="<?php echo $upload_logo; ?>" placeholder="Upload logo" class="cn-form-control">
				        </div>
				        <div class="cn_col-md-12 mt-2 p-0">
				        	<button type="button" class="button" onclick="image_upl();">Upload Logo</button>
				        </div>
			      	</div>
			</div>
		</div>
		<div class="cn-form-group mb-2">
		  	<div class="row">
				<div class="cn_col-md-6">
					<label class="control-label" for="name">Tagline:</label>
			        <div class="cn_col-md-12 p-0">
			          <input type="text" name="tagline_text" value="<?php echo $tagline_text; ?>" placeholder="Tagline" class="cn-form-control">
			        </div>
				</div>
				<div class="cn_col-md-6">
					<label class="control-label" for="name">Notice:</label>
			        <div class="cn_col-md-12 p-0">
			          <input type="text" name="notice_text" value="<?php echo $notice_text; ?>" placeholder="Notice Text" class="cn-form-control">
			        </div>
				</div>
			</div>
		</div>
		
		
		
	  <?php
	}
	public function post_meta_box_save( $post_id ) {
	  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	  return;
	  if ( !wp_verify_nonce( $_POST['post_meta_box_content_nonce'], plugin_basename( __FILE__ ) ) )
	  return;

	  if ( 'page' == $_POST['post_type'] ) {
	    if ( !current_user_can( 'edit_page', $post_id ) )
	    return;
	  } else {
	    if ( !current_user_can( 'edit_post', $post_id ) )
	    return;
	  }
	  update_post_meta($post_id, 'upload_logo', $_POST['upload_logo']);
	  update_post_meta($post_id, 'tagline_text', $_POST['tagline_text']);
	  update_post_meta($post_id, 'notice_text', $_POST['notice_text']);
	  update_post_meta($post_id, 'another_product_sku', $_POST['another_product_sku']);
	  
	  
	 
	}

}
