<?php
/**
@package New Photo Gallery
Plugin Name: New Photo Gallery
Plugin URI: http://awplife.com/
Description: new photo gallery plugin with lightbox preview for Wordpress
Version: 0.1.4
Author: A WP Life
Author URI: http://awplife.com/
License: GPLv2 or later
Text Domain: LGP_TXTDM
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'New_Light_Image_Gallery' ) ) {

	class New_Light_Image_Gallery {
		
		protected $protected_plugin_api;
		protected $ajax_plugin_nonce;
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}		
		
		protected function _constants() {
			//Plugin Version
			define( 'LG_PLUGIN_VER', '0.1.0' );
			
			//Plugin Text Domain
			define('LGP_TXTDM','awl-light-image-gallery' );

			//Plugin Name
			define( 'LG_PLUGIN_NAME', __( 'New Photo Gallery', 'LGP_TXTDM' ) );

			//Plugin Slug
			define( 'LG_PLUGIN_SLUG', '_light_image_gallery' );

			//Plugin Directory Path
			define( 'LG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'LG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'LG_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		
		/**
		 * Setup the default filters and actions
		 */
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, '_srgallery_menu' ), 101 );
			
			//Create Image Gallery Custom Post
			add_action( 'init', array( $this, 'light_image_gallery' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );
			 
			//loaded during admin init 
			add_action( 'admin_init', array( $this, '_admin_add_meta_box' ) );
			
			add_action('wp_ajax_image_gallery_js', array(&$this, '_ajax_light_image_gallery'));
		
			add_action('save_post', array(&$this, '_lg_save_settings'));

			//Shortcode Compatibility in Text Widgets
			add_filter('widget_text', 'do_shortcode');

		} // end of hook function
		
		
		/**
		 * Loads the text domain.
		 */
		public function _load_textdomain() {
			load_plugin_textdomain( 'LGP_TXTDM', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}		
		
		/**
		 * Adds the Gallery menu item
		 */
		public function _srgallery_menu() {
			$help_menu = add_submenu_page( 'edit.php?post_type='.LG_PLUGIN_SLUG, __( 'Docs', 'LGP_TXTDM' ), __( 'Docs', 'LGP_TXTDM' ), 'administrator', 'sr-doc-page', array( $this, '_lg_doc_page') );
		}		
		
		/**
		 * Image Gallery Custom Post
		 * Create gallery post type in admin dashboard.
		 */
		public function light_image_gallery() {
			$labels = array(
				'name'                => _x( 'New Photo Gallery', 'Post Type General Name', 'LGP_TXTDM' ),
				'singular_name'       => _x( 'New Photo Gallery', 'Post Type Singular Name', 'LGP_TXTDM' ),
				'menu_name'           => __( 'New Photo Gallery', 'LGP_TXTDM' ),
				'name_admin_bar'      => __( 'New Photo Gallery', 'LGP_TXTDM' ),
				'parent_item_colon'   => __( 'Parent Item:', 'LGP_TXTDM' ),
				'all_items'           => __( 'All Photo Gallery', 'LGP_TXTDM' ),
				'add_new_item'        => __( 'Add New Photo Gallery', 'LGP_TXTDM' ),
				'add_new'             => __( 'Add New Gallery', 'LGP_TXTDM' ),
				'new_item'            => __( 'New Photo Gallery', 'LGP_TXTDM' ),
				'edit_item'           => __( 'Edit New Photo Gallery', 'LGP_TXTDM' ),
				'update_item'         => __( 'Update New Photo Gallery', 'LGP_TXTDM' ),
				'search_items'        => __( 'Search New Photo Gallery', 'LGP_TXTDM' ),
				'not_found'           => __( 'Photo Gallery Not found', 'LGP_TXTDM' ),
				'not_found_in_trash'  => __( 'Photo Gallery Not found in Trash', 'LGP_TXTDM' ),
			);
			$args = array(
				'label'               => __( 'New Photo Gallery', 'LGP_TXTDM' ),
				'label'               => __( 'New Photo Gallery', 'LGP_TXTDM' ),
				'description'         => __( 'Custom Post Type For New Photo Gallery', 'LGP_TXTDM' ),
				'labels'              => $labels,
				'supports'            => array( 'title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-images-alt2',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( '_light_image_gallery', $args );
			
		} // end of post type function
		
		/**
		 * Adds Meta Boxes
		 */
		public function _admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( '', __('Add Image', LGP_TXTDM), array(&$this, 'lg_upload_multiple_images'), '_light_image_gallery', 'normal', 'default' );
		}
		
		public function lg_upload_multiple_images($post) { 
			wp_enqueue_script('media-upload');
			wp_enqueue_script('awl-lg-uploader.js', LG_PLUGIN_URL . 'js/awl-lg-uploader.js', array('jquery'));
			wp_enqueue_style('awl-lg-uploader-css', LG_PLUGIN_URL . 'css/awl-lg-uploader.css');
			wp_enqueue_media();
			
			//wp_enqueue_style( 'wp-color-picker' );
			//wp_enqueue_script( 'awl-lg-color-picker-js', plugins_url('js/lg-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
			?>
			<div id="photer-gallery">
				<input type="button" id="remove-all-photos" name="remove-all-photos" class="button button-large remove-all-photos" rel="" value="<?php _e('Delete All Images', 'LGP_TXTDM'); ?>">
				<ul id="remove-photos" class="pbox">
					<?php
					$allimagesetting = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_lg_settings_'.$post->ID, true)));
					if(isset($allimagesetting['slide-ids'])) {
						$count = 0;
					foreach($allimagesetting['slide-ids'] as $id) {
						$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
						$attachment = get_post( $id );
						$image_link =  $allimagesetting['slide-link'][$count];
						$image_type =  $allimagesetting['slide-type'][$count];
						?>
						<li class="photo">
							<img class="new-photo" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
							<input type="hidden" id="slide-ids[]" name="slide-ids[]" value="<?php echo $id; ?>" />
							<!-- Image Title, Caption, Alt Text, Description-->
							<select id="slide-type[]" name="slide-type[]" class="form-control" style="width: 100%;" placeholder="Image Title" value="<?php echo $image_type; ?>" >
								<option value="image" <?php if($image_type == "image") echo "selected=selected"; ?>> Image </option>
								<option value="video" <?php if($image_type == "video") echo "selected=selected"; ?>> Video </option>
							</select>
							<input type="text" name="slide-title[]" id="slide-title[]" style="width: 100%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">	
							<input type="text" name="slide-link[]" id="slide-link[]" style="width: 100%;" placeholder="YouTube / Vimeo Video URL" value="<?php echo $image_link; ?>">
							<input type="button" name="remove-photo" id="remove-photo" class="button remove-single-photo button-danger" style="width: 100%;" value="Delete">
						</li>
						<?php $count++; } // end of foreach
					} //end of if
				?>
				</ul>
			</div>
			
			<!--Add New Image Button-->
			<div name="add-new-photer" id="add-new-photer" class="new-photer" style="height: 160px; width: 160px; border-radius: 8px;">
				<div class="menu-icon dashicons dashicons-format-image"></div>
				<div class="add-text"><?php _e('Add Image', 'LGP_TXTDM'); ?></div>
			</div>
			<div style="clear:left;"></div>
			<br>
			<br>
			<h1>Copy Light Image Gallery Shortcode</h1>
			<hr>
			<p class="input-text-wrap">
				<p><?php _e('Copy & Embed shotcode into any Page/ Post / Text Widget to display your Light image gallery on site.', 'LGP_TXTDM'); ?><br></p>
				<input type="text" name="shortcode" id="shortcode" value="<?php echo "[NPG id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" onmouseover="return pulseOff();" onmouseout="return pulseStart();">
			</p>
			<br>
			<br>
			<h1><?php _e('Light Image Gallery Settings', 'LGP_TXTDM'); ?></h1>
			<hr>
			<?php
			require_once('gallery-settings.php');
		} // end of upload multiple image
		
		public function _lg_ajax_callback_function($id) {
			//wp_get_attachment_image_src ( int $attachment_id, string|array $size = 'thumbnail', bool $icon = false )
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			?>
			<li class="photo">
				<img class="new-photo" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
				<input type="hidden" id="slide-ids[]" name="slide-ids[]" value="<?php echo $id; ?>" />
				<select id="slide-type[]" name="slide-type[]" class="form-control" style="width: 100%;" placeholder="Image Title" value="<?php echo $image_type; ?>" >
					<option value="image" <?php if($image_type == "image") echo "selected=selected"; ?>> Image </option>
					<option value="video" <?php if($image_type == "video") echo "selected=selected"; ?>> Video </option>
				</select>
				<input type="text" name="slide-title[]" id="slide-title[]" style="width: 100%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">
				<input type="text" name="slide-link[]" id="slide-link[]" style="width: 100%;" placeholder="YouTube / Vimeo Video URL">				
				<input type="button" name="remove-photo" id="remove-photo" style="width: 100%;" class="button" value="Delete">
			</li>
			<?php
		} 
		
		public function _ajax_light_image_gallery() {
			echo $this->_lg_ajax_callback_function($_POST['slideId']);
			die;
		}
		
		public function _lg_save_settings($post_id) {
			if ( isset( $_POST['ig-settings'] ) == "ig-save-settings" ) {
				$image_ids = $_POST['slide-ids'];
				$image_titles = $_POST['slide-title'];
				$image_type = $_POST['slide-type'];
				$i = 0;
				foreach($image_ids as $image_id) {
					$single_image_update = array(
						'ID'           => $image_id,
						'post_title'   => $image_titles[$i],
					);
					wp_update_post( $single_image_update );
					$i++;
				}				
				$awl_light_image_gallery_shortcode_setting = "awl_lg_settings_".$post_id;
				update_post_meta($post_id, $awl_light_image_gallery_shortcode_setting, base64_encode(serialize($_POST)));
			}
		}// end save setting
		
		/**
		 * Light Image Gallery Docs Page
		 * Create doc page to help user to setup plugin
		 */
		public function _lg_doc_page() {
			require_once('docs.php');
		}		
	}// end of class

	/**
	 * Instantiates the Class
	 */
	$lg_gallery_object = new New_Light_Image_Gallery();
	require_once('shortcode.php');
} // end of class exists
?>