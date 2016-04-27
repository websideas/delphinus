<?php
	$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
	
	extract( shortcode_atts( array(
		'el_class'        	=> '',
		'bg_image'        	=> '',
		'bg_color'        	=> '',
		'bg_image_repeat'	=> '',
		'font_color'      	=> '',
		'padding'         	=> '',
		'margin_bottom'   	=> '',
		'css' 				=> '',
		// Custom params
		'type' 				=> ''
	), $atts ) );
	
	$el_class = $this->getExtraClass( $el_class );
	$row_class = 'nm-row nm-row-' . $type . ' inner ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $row_class, $this->settings['base'], $atts );
	
	$output .= '<div class="' . $css_class . '">';
	$output .= wpb_js_remove_wpautop( $content );
	$output .= '</div>' . $this->endBlockComment( 'row' );
	
	echo $output;
