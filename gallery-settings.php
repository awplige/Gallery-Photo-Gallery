<?php
//toggle button CSS
wp_enqueue_style('awl-em-event_monster-css', LG_PLUGIN_URL . 'css/toogle-button.css');
wp_enqueue_style('awl-font-awesome-css', LG_PLUGIN_URL . 'css/font-awesome.min.css');
wp_enqueue_style('awl-go-to-top-css', LG_PLUGIN_URL . 'css/go-to-top.css');
//js
wp_enqueue_script('jquery');
wp_enqueue_script( 'awl-go-to-top-js',  LG_PLUGIN_URL .'js/go-to-top.js', array( 'jquery' ), '', true  );

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//load settings
$gallery_settings = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_lg_settings_'.$post->ID, true)));
//print_r($gallery_settings);
$light_image_gallery_id = $post->ID;
?>

<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<style>	
	.gal_settings {
		font-size: 16px !important;
		padding-left: 4px;
		font: initial;
		margin-top: 5px;
		font-weight: 600;
		padding-left:14px;
	}
	
	.wp-color-result::after {
		height: 25px;
	}
	.wp-picker-container input.wp-color-picker[type="text"] {
		width: 80px !important;
		height: 22px !important;
		float: left;
		font-size: 11px !important;
	}
	.iris-border .iris-palette-container {
		bottom: 6px;
	}
	.wp-core-ui .button, .wp-core-ui .button.button-large, .wp-core-ui .button.button-small, a.preview, input#publish, input#save-post {
		height: auto !important;
		padding: 0 12px !important;
	}
	
</style>
<div>
	<p class="bg-title">1. Gallery Thumbnail Size</p></br>
	<?php if(isset($gallery_settings['gal_thumb_size'])) $gal_thumb_size = $gallery_settings['gal_thumb_size']; else $gal_thumb_size = "thumbnail"; ?>
	<select id="gal_thumb_size" name="gal_thumb_size" style="margin-left: 15px; width: 300px;">
		<option value="thumbnail" <?php if($gal_thumb_size == "thumbnail") echo "selected=selected"; ?>>Thumbnail – 150 × 150</option>
		<option value="medium" <?php if($gal_thumb_size == "medium") echo "selected=selected"; ?>>Medium – 300 × 169</option>
		<option value="large" <?php if($gal_thumb_size == "large") echo "selected=selected"; ?>>Large – 840 × 473</option>
		<option value="full" <?php if($gal_thumb_size == "full") echo "selected=selected"; ?>>Full Size – 1280 × 720</option>
	</select><br>
	<p class="gal_settings"><?php _e('Select gallery thumnails size to display into gallery', LGP_TXTDM); ?></p>
</div><br>

<div>
	<p class="bg-title">2. Columns Layout Settings</p>
	<p class="bg-lower-title">A. Column On Large Desktops</p></br>
	<?php if(isset($gallery_settings['col_large_desktops'])) $col_large_desktops = $gallery_settings['col_large_desktops']; else $col_large_desktops = "col-lg-2"; ?>
	<select id="col_large_desktops" name="col_large_desktops" class="form-control" style="margin-left: 15px; width: 300px;">
		<option value="col-lg-12" <?php if($col_large_desktops == "col-lg-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-lg-6" <?php if($col_large_desktops == "col-lg-6") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-lg-4" <?php if($col_large_desktops == "col-lg-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-lg-3" <?php if($col_large_desktops == "col-lg-3") echo "selected=selected"; ?>>4 Column</option>
		<option value="col-lg-2" <?php if($col_large_desktops == "col-lg-2") echo "selected=selected"; ?>>6 Column</option>
		<option value="col-lg-1" <?php if($col_large_desktops == "col-lg-1") echo "selected=selected"; ?>>12 Column</option>
	</select><br>
	<p class="gal_settings"><?php _e('Select gallery column layout for large desktop devices', LGP_TXTDM); ?></p>
</div>
<div>
	<p class="bg-lower-title">B. Column On Desktops</p></br>
	<?php if(isset($gallery_settings['col_desktops'])) $col_desktops = $gallery_settings['col_desktops']; else $col_desktops = "col-md-3"; ?>
	<select id="col_desktops" name="col_desktops" class="form-control" style="margin-left: 15px; width: 300px;">
		<option value="col-md-12" <?php if($col_desktops == "col-md-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-md-6" <?php if($col_desktops == "col-md-6") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-md-4" <?php if($col_desktops == "col-md-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-md-3" <?php if($col_desktops == "col-md-3") echo "selected=selected"; ?>>4 Column</option>
		<option value="col-md-2" <?php if($col_desktops == "col-md-2") echo "selected=selected"; ?>>6 Column</option>
		<option value="col-md-1" <?php if($col_desktops == "col-md-1") echo "selected=selected"; ?>>12 Column</option>
	</select><br>
	<p class="gal_settings"><?php _e('Select gallery column layout for desktop devices', LGP_TXTDM); ?></p>
</div>
<div>
	<p class="bg-lower-title">C. Column On Tablets</p></br>
	<?php if(isset($gallery_settings['col_tablets'])) $col_tablets = $gallery_settings['col_tablets']; else $col_tablets = "col-sm-4"; ?>
	<select id="col_tablets" name="col_tablets" class="form-control" style="margin-left: 15px; width: 300px;">
		<option value="col-sm-12" <?php if($col_tablets == "col-sm-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-sm-6" <?php if($col_tablets == "col-sm-6") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-sm-4" <?php if($col_tablets == "col-sm-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-sm-3" <?php if($col_tablets == "col-sm-3") echo "selected=selected"; ?>>4 Column</option>
		<option value="col-sm-2" <?php if($col_tablets == "col-sm-2") echo "selected=selected"; ?>>6 Column</option>
	</select><br>
	<p class="gal_settings"><?php _e('Select gallery column layout for tablet devices', LGP_TXTDM); ?></p>
</div>
<div>
	<p class="bg-lower-title">D. Column On Phones</p></br>
	<?php if(isset($gallery_settings['col_phones'])) $col_phones = $gallery_settings['col_phones']; else $col_phones = "col-xs-6"; ?>
	<select id="col_phones" name="col_phones" class="form-control" style="margin-left: 15px; width: 300px;">
		<option value="col-xs-12" <?php if($col_phones == "col-xs-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-xs-6" <?php if($col_phones == "col-xs-6") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-xs-4" <?php if($col_phones == "col-xs-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-xs-3" <?php if($col_phones == "col-xs-3") echo "selected=selected"; ?>>4 Column</option>
	</select><br>
	<p class="gal_settings"><?php _e('Select gallery column layout for phone devices', LGP_TXTDM); ?></p>
</div>

<!--start gallery tools settings -->
	<div>
		<p class="bg-title"><?php _e('3. Lightbox Tool Color', LGP_TXTDM); ?></p><br>&nbsp;&nbsp;
		<?php if(isset($gallery_settings['tool_color'])) $tool_color = $gallery_settings['tool_color']; else $tool_color = "gold"; ?>
		<input type="text" class="form-control" id="tool_color" name="tool_color" placeholder="type color name / code" value="<?php echo $tool_color; ?>" default-color="<?php echo $tool_color; ?>"><br>
		<p class="gal_settings"><?php _e('You can change color of lightbox tools for light gallery', LGP_TXTDM); ?>
	</div>
<!--end gallery tools settings -->

<div>
	<p class="bg-title"><?php _e('4. Title Color', LGP_TXTDM); ?></p><br>&nbsp;&nbsp;
	<?php if(isset($gallery_settings['title_color'])) $title_color = $gallery_settings['title_color']; else $title_color = "white"; ?>
	<input type="text" class="form-control" id="title_color" name="title_color" placeholder="type color name / code" value="<?php echo $title_color; ?>" default-color="<?php echo $title_color; ?>"><br>
	<p class="gal_settings"><?php _e('You can change title color of image / photo', LGP_TXTDM); ?></p>
</div>

<!-- Start Hover Effect Settings -->
<div>
	<p class="bg-title"><?php _e('5. Image Hover Effect Type', LGP_TXTDM); ?></p></br>
	<p class="switch-field em_size_field">	
		<?php if(isset($gallery_settings['image_hover_effect_type'])) $image_hover_effect_type = $gallery_settings['image_hover_effect_type']; else $image_hover_effect_type = "no"; ?>
		<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type1" value="no" <?php if($image_hover_effect_type == "no") echo "checked=checked"; ?>>
		<label for="image_hover_effect_type1"><?php _e('None', LGP_TXTDM); ?></label>
		<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type2" value="sg" <?php if($image_hover_effect_type == "sg") echo "checked=checked"; ?>>
		<label for="image_hover_effect_type2"><?php _e('Shadow & Glow', LGP_TXTDM); ?></label>
		<p class="gal_settings"><?php _e('Select a image/photo hover effect type', LGP_TXTDM); ?></p>
	</p>
</div>

<!-- 4 -->
<div class="he_two">
	<label style="font-size: x-large; padding-left:15px;"><?php _e('Image Hover Effects', LGP_TXTDM); ?></label><br><br>
	<?php if(isset($gallery_settings['image_hover_effect_four'])) $image_hover_effect_four = $gallery_settings['image_hover_effect_four']; else $image_hover_effect_four = "hvr-box-shadow-outset"; ?>
	<select name="image_hover_effect_four" id="image_hover_effect_four" style="margin-left: 15px; width: 300px;">
		<optgroup label="Shadow and Glow Transitions Effects" class="sg">
			<option value="hvr-grow-shadow" <?php if($image_hover_effect_four == "hvr-grow-shadow") echo "selected=selected"; ?>>Grow Shadow</option>
			<option value="hvr-float-shadow" <?php if($image_hover_effect_four == "hvr-float-shadow") echo "selected=selected"; ?>>Float Shadow</option>
			<option value="hvr-glow" <?php if($image_hover_effect_four == "hvr-glow") echo "selected=selected"; ?>>Glow</option>
			<option value="hvr-box-shadow-outset" <?php if($image_hover_effect_four == "hvr-box-shadow-outset") echo "selected=selected"; ?>>Box Shadow Outset</option>
			<option value="hvr-box-shadow-inset" <?php if($image_hover_effect_four == "hvr-box-shadow-inset") echo "selected=selected"; ?>>Box Shadow Inset</option>
		</optgroup>
	</select><br>
	<p class="he_two gal_settings"><?php _e('Set an image/photo hover effect on gallery', LGP_TXTDM); ?></p>
</div>
<!-- End Hover Effect Settings -->

<div>
	<p class="bg-title">6. Effect Types On Change Image</p></br>
	<?php if(isset($gallery_settings['transition_effects'])) $transition_effects = $gallery_settings['transition_effects']; else $transition_effects = "lg-fade"; ?>
	<select id="transition_effects" name="transition_effects" class="form-control" style="margin-left: 15px; width: 300px;">
		<option value="none" <?php if($transition_effects == "none") echo "selected=selected"; ?>>None</option>
		<option value="lg-slide" <?php if($transition_effects == "lg-slide") echo "selected=selected"; ?>>slide</option>
		<option value="lg-fade" <?php if($transition_effects == "lg-fade") echo "selected=selected"; ?>>fade</option>
		<option value="lg-zoom-in" <?php if($transition_effects == "lg-zoom-in") echo "selected=selected"; ?>>zoom-in</option>
		<option value="lg-zoom-in-big" <?php if($transition_effects == "lg-zoom-in-big") echo "selected=selected"; ?>>zoom-in-big Effect</option>
	</select><br>
	<p class="gal_settings"><?php _e('Select custom effects for light image gallery', LGP_TXTDM); ?></p>
</div>

<div>
	<p class="bg-title"><?php _e('7. Thumbnails Spacing', LGP_TXTDM); ?></p><br>
	<p class="switch-field em_size_field">
		<?php if(isset($gallery_settings['thumbnails_spacing'])) $thumbnails_spacing = $gallery_settings['thumbnails_spacing']; else $thumbnails_spacing = 1; ?>
		<input type="radio" name="thumbnails_spacing" id="thumbnails_spacing1" value="1" <?php if($thumbnails_spacing == 1) echo "checked=checked"; ?>>
		<label for="thumbnails_spacing1"><?php _e('Yes', LGP_TXTDM); ?></label>
		<input type="radio" name="thumbnails_spacing" id="thumbnails_spacing2" value="0" <?php if($thumbnails_spacing == 0) echo "checked=checked"; ?>>
		<label for="thumbnails_spacing2"><?php _e('No', LGP_TXTDM); ?></label>
		<p class="gal_settings"><?php _e('Hide gap / margin / padding / spacing between gallery thumbnails', LGP_TXTDM); ?></p>
	</p>
</div>

<div>
	<p class="bg-title"><?php _e('8. Custom CSS', LGP_TXTDM); ?></p></br>
	<?php if(isset($gallery_settings['custom-css'])) $custom_css = $gallery_settings['custom-css']; else $custom_css = ""; ?>
	<textarea name="custom-css" id="custom-css" style="width: 100%; height: 120px;" placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo $custom_css; ?></textarea><br>
	<p class="gal_settings"><?php _e('Apply own css on light image gallery and dont use style tag', LGP_TXTDM); ?></p>
</div>

<input type="hidden" name="ig-settings" id="ig-settings" value="ig-save-settings">

<script>
//hover effect hide and show 
	var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
	if(effect_type == "no") {
		jQuery('.he_one').hide();
		jQuery('.he_two').hide();
	}
	
	if(effect_type == "sg") {
		jQuery('.he_one').hide();
		jQuery('.he_two').show();
	}
	
	//on change effect
	jQuery(document).ready(function() {
		// image hover effect hide show
		jQuery('input[name="image_hover_effect_type"]').change(function(){
			var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
			if(effect_type == "no") {
				jQuery('.he_one').hide();
				jQuery('.he_two').hide();		
			}
			if(effect_type == "sg") {
				jQuery('.he_one').hide();
				jQuery('.he_two').show();
			}
		})	
	});
		
// start pulse on page load
	function pulseEff() {
	   jQuery('#shortcode').fadeOut(600).fadeIn(600);
	};
	var Interval;
	Interval = setInterval(pulseEff,1500);

	// stop pulse
	function pulseOff() {
		clearInterval(Interval);
	}
	// start pulse
	function pulseStart() {
		Interval = setInterval(pulseEff,1500);
	}
</script>
	<hr><br><br>
	<p class="">&nbsp;&nbsp;
		<a href="http://awplife.com/account/signup/photo-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Buy Premium Version</a>
		<a href="http://demo.awplife.com/photo-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Check Live Demo</a>
		<a href="http://demo.awplife.com/photo-gallery-premium-admin-demo/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Try Admin Demo</a>
	</p>
	<hr>
	<style>
		.awp_bale_offer {
			background-image: url("<?php echo LG_PLUGIN_URL ?>/image/awp-bale.jpg");
			background-repeat:no-repeat;
			padding:30px;
		}
		.awp_bale_offer h1 {
			font-size:35px;
			color:#FFFFFF;
		}
		.awp_bale_offer h3 {
			font-size:25px;
			color:#FFFFFF;
		}
	</style>
	<div class="row awp_bale_offer">
		<div class="">
			<h1>Plugin's Bale Offer</h1>
			<h3>Get All Premium Plugin ( Personal Licence) in just $99 </h3>
			<h3><strike>$149</strike> For $99 Only</h3>
		</div>
		<div class="">
			<a href="http://awplife.com/account/signup/all-premium-plugins" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">BUY NOW</a>
		</div>
	</div>
	<hr>
	<h1><strong>&nbsp;&nbsp;Try Over Other Plugins:</strong></h1>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="https://wordpress.org/plugins/portfolio-filter-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Portfolio Filter Gallery</a>
		<a href="https://wordpress.org/plugins/new-grid-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Grid Gallery</a>
		<a href="https://wordpress.org/plugins/new-social-media-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Social Media</a>
		<a href="https://wordpress.org/plugins/new-image-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Image Gallery</a>
		<a href="https://wordpress.org/plugins/new-photo-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Photo Gallery</a>
		<a href="https://wordpress.org/plugins/responsive-slider-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Responsive Slider Gallery</a>
		<a href="https://wordpress.org/plugins/new-contact-form-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Contact Form Widget</a><br><br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://wordpress.org/plugins/facebook-likebox-widget-and-shortcode/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Facebook Likebox Plugin</a>
		<a href="https://wordpress.org/plugins/slider-responsive-slideshow/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Slider Responsive Slideshow</a>
		<a href="https://wordpress.org/plugins/new-video-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Video Gallery</a>
		<a href="https://wordpress.org/plugins/new-facebook-like-share-follow-button/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Facebook Like Share Follow Button</a>
		<a href="https://wordpress.org/plugins/new-google-plus-badge/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Google Plus Badge</a>
		<a href="https://wordpress.org/plugins/media-slider/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Media Slider</a><br><br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://wordpress.org/plugins/weather-effect/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Weather Effect</a>
	</p>