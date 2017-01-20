<?php
/**
 * New Photo Gallery Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_shortcode('NPG', 'awl_photo_gallery_shortcode');
function awl_photo_gallery_shortcode($post_id) {
	ob_start();
	//js
	wp_enqueue_script('jquery');
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('awl-lg-isotope-js', LG_PLUGIN_URL .'js/isotope.pkgd.js', array('jquery'), '' , true);
	
	// awp custom bootstrap css
	wp_enqueue_style('awl-lg-bootstrap-css', LG_PLUGIN_URL .'css/lg-bootstrap.css');
	
	
	$gallery_settings = unserialize(base64_decode(get_post_meta( $post_id['id'], 'awl_lg_settings_'.$post_id['id'], true)));
	//print_r($gallery_settings);
	
	$light_image_gallery_id = $post_id['id'];
	
	//columns settings	
	$gal_thumb_size = $gallery_settings['gal_thumb_size'];
	$col_large_desktops = $gallery_settings['col_large_desktops'];
	$col_desktops = $gallery_settings['col_desktops'];
	$col_tablets = $gallery_settings['col_tablets'];
	$col_phones = $gallery_settings['col_phones'];
	
	// ligtbox style
	if(isset($gallery_settings['light-box'])) $light_box = $gallery_settings['light-box']; else $light_box = 1;
	
	// transition Effect
	if(isset($gallery_settings['transition_effects'])) $transition_effects = $gallery_settings['transition_effects']; else $transition_effects = "lg-fade";
	if($transition_effects != "none"){
		// transition effects css
		wp_enqueue_style('awl-lg-transitions-css', LG_PLUGIN_URL . 'lightbox/light-gallery/css/lg-transitions.css');
	}
	
	//hover effect
	if(isset($gallery_settings['image_hover_effect_type'])) $image_hover_effect_type = $gallery_settings['image_hover_effect_type']; else $image_hover_effect_type = "no";
	if($image_hover_effect_type == "no") {
		$image_hover_effect = "";
	} else {
		// hover csss
		wp_enqueue_style('lg-hover-css', LG_PLUGIN_URL .'css/hover.css');
	}
	
	if($image_hover_effect_type == "sg")
		if(isset($gallery_settings['image_hover_effect_four'])) $image_hover_effect = $gallery_settings['image_hover_effect_four']; else $image_hover_effect = "hvr-box-shadow-outset";
	
	if(isset($gallery_settings['title_color'])) $title_color = $gallery_settings['title_color']; else $title_color = "white";
	if(isset($gallery_settings['tool_color'])) $tool_color = $gallery_settings['tool_color']; else $tool_color = "gold";
	if(isset($gallery_settings['thumbnails_spacing'])) $thumbnails_spacing = $gallery_settings['thumbnails_spacing']; else $thumbnails_spacing = 1;
	if(isset($gallery_settings['custom-css'])) $custom_css = $gallery_settings['custom-css']; else $custom_css = "";
	?>
	<!-- CSS Part Start From Here-->
	<style>
		#animated-thumbnials-<?php echo $light_image_gallery_id; ?> a {
			text-decoration: none !important;
			box-shadow: 0 0px 0 0 currentcolor !important;
		}
		<?php if($thumbnails_spacing == 0) { ?>
			#animated-thumbnials-<?php echo $light_image_gallery_id; ?> .thumbnail {
				border: 0px !important;
				border-radius: 0px !important;
				display: block;
				line-height: 1.42857;
				margin-bottom: 0px !important;
				padding: 0px !important;
			}
			#animated-thumbnials-<?php echo $light_image_gallery_id; ?> img {
				width: 100% !important;
			}
			
			#animated-thumbnials-<?php echo $light_image_gallery_id; ?> .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
				padding-left: 0px !important;
				padding-right: 0px !important;
			}
		<?php } ?>
			.lg-icon {
				color : <?php echo $tool_color; ?> !important;
			}
			.pg-titile {
				color: <?php echo $title_color; ?> !important;
			}
		
		<?php echo $custom_css; ?>
	</style>
	<?php
	require('thumbnail.php');
	return ob_get_clean();
}
?>