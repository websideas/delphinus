<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once (KT_FW_DIR . 'js_composer/vc_addons/heading.php');

class WPBakeryShortCode_Products_Tab extends WPBakeryShortCode_KT_Heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'text' => '',
            'subtitle' => '',
            'backend' => '',
            'align' => 'center',
            'layout' => '1',
            'font_container' => '',
            'use_theme_fonts' => 'yes',
            'google_fonts' => '',
            'font_container_subtitle' => '',
            'font_container_backend' => '',



            'source' => 'widgets',
            'categories' => '',
            'per_page' => 8,
            'products_layout' => 'grid',
            'columns' => 4,
            'orderby' => 'date',
            'order' => 'DESC',
            'hover_effect'=> '',
            'active_section' => 1,
            'css_animation' => '',
            'el_class' => '',
            'css' => '',
            'nav' => '1',
            'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.

            'product_columns' => '4',
            'product_columns_desktop' => '3',
            'product_columns_tablet' => '2',
            'divider' => ''

        ), $atts );

        if($atts['products_layout'] == 'carousel'){
            $atts['columns'] = $atts['product_columns'];
        }


        extract($atts);

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wc-products-tab', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'align' => 'wc-products-'.$align,
        );

        $heading = '';
        if($text){
            $elementClassHeading = array(
                'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-heading ', $this->settings['base'], $atts ),
                'align' => 'text-'.$align,
                'layout' => 'style'.$layout,
            );

            $heading = $style_title_css = $style_backend_css = $style_subtitle_css = '';

            $style_title = $this->getCustomStyle($atts);
            if ( ! empty( $style_title['style'] ) ) {
                $style_title_css = 'style="' . esc_attr( implode( ';', $style_title['style'] ) ) . '"';
            }
            $heading_title = '<' . $style_title['data']['values']['tag'] . ' class="kt-heading-title" ' . $style_title_css . ' >'.$text.'</' . $style_title['data']['values']['tag'] . '>';

            $heading_subtitle = '';
            if($subtitle){
                $atts['font_container'] = $atts['font_container_subtitle'];
                $atts['google_fonts'] = '';
                $style_subtitle = $this->getCustomStyle($atts);
                if ( ! empty( $style_subtitle['style'] ) ) {
                    $style_subtitle_css = 'style="' . esc_attr( implode( ';', $style_subtitle['style'] ) ) . '"';
                }
                $heading_subtitle = '<div class="kt-heading-subtitle" ' . $style_subtitle_css . '>'.$subtitle.'</div>';
            }

            $heading_backend = '';
            if($backend){
                $atts['font_container'] = $atts['font_container_backend'];
                $atts['google_fonts'] = '';
                $style_backend = $this->getCustomStyle($atts);
                if ( ! empty( $style_backend['style'] ) ) {
                    $style_backend_css = 'style="' . esc_attr( implode( ';', $style_backend['style'] ) ) . '"';
                }
                $heading_backend = '<div class="kt-heading-backend" ' . $style_backend_css . '>'.$backend.'</div>';
            }

            $heading .= $heading_backend.$heading_title.$heading_subtitle;


            $elementClassHeading = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClassHeading ) );
            $heading = '<div class="'.esc_attr( $elementClassHeading ).'">'.$heading.'</div>';
        }


        $uniqeID = uniqid();

        $meta_query = WC()->query->get_meta_query();
        $args = array(
            'post_type'				=> 'product',
            'post_status'			=> 'publish',
            'ignore_sticky_posts'	=> 1,
            'posts_per_page' 		=> $atts['per_page'],
            'meta_query' 			=> $meta_query
        );

        $tabs = array();
        if($source == 'categories'){
            $tabs = explode(',', $categories);
            $args['order'] = $order;
            $args['orderby'] = $orderby;
        }else{
            $tabs = array('featured', 'new', 'bestselling');
        }

        $tab_heading = '<ul class="nav nav-style-'.$nav.'" data-count="'.count($tabs).'">';

        $i = 1;
        foreach($tabs as $tab){
            if($source == 'categories'){
                $term = get_term_by('slug', sanitize_title($tab), 'product_cat');
                $text = $term->name;
            }else{
                if($tab == 'featured'){
                    $text = esc_html__('Hot Products', 'wingman');
                }elseif($tab == 'new'){
                    $text = esc_html__('New Arrivals', 'wingman');
                }elseif($tab == 'bestselling'){
                    $text = esc_html__('Best Sellers', 'wingman');
                }
            }
            $class = ($active_section == $i) ? ' class="active"' : '';
            $tab_heading .= sprintf( '<li %s><a href="%s" data-toggle="tab"><span data-hover="%s">%s</span></a></li>', $class, '#tab-'.$tab.'-'.$uniqeID, esc_attr($text), $text );
            $i++;
        }
        $tab_heading .= "</ul>";

        if( $divider ){
            $tab_heading .= sprintf('<div class="nav-divider-%s"></div>', $divider);
        }

        global $woocommerce_loop;

        $i = 1;
        $output_content = '';

        foreach($tabs as $tab){

            $new_args = $args;

            if($source == 'categories'){
                $new_args['tax_query'] = array(
                    array(
                        'taxonomy' 		=> 'product_cat',
                        'terms' 		=> sanitize_title($tab),
                        'field' 		=> 'slug',
                        'operator' 		=> $atts['operator']
                    )
                );
            }else{
                if( $tab == 'bestselling' ){
                    $new_args['meta_key'] = 'total_sales';
                    $new_args['orderby'] = 'meta_value_num';

                }elseif( $tab == 'featured' ){
                    $new_args['meta_query'][] = array(
                        'key'   => '_featured',
                        'value' => 'yes'
                    );
                }
            }

            $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $new_args, $atts ) );
            $woocommerce_loop['columns'] = $atts['columns'];
            $woocommerce_loop['effect'] = $atts['hover_effect'];

            ob_start();
            if ( $products->have_posts() ) {

                if($products_layout == 'carousel'){
                    echo sprintf(
                        '<div class="owl-carousel-kt"><div class="wc-carousel-wrapper" data-options=\'{"desktop": "%s","desktopsmall": "%s","tablet": "%s","mobile": "1","navigation": true, "pagination": false}\'>',
                        $product_columns,
                        $product_columns_desktop,
                        $product_columns_tablet
                    );
                }

                woocommerce_product_loop_start();
                while ( $products->have_posts() ) : $products->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile; // end of the loop.
                woocommerce_product_loop_end();
                if($products_layout == 'carousel'){
                    echo '</div></div>';
                }

            }
            woocommerce_reset_loop();
            wp_reset_postdata();



            $class = ($active_section == $i) ? 'fade in active' : '';
            $output_content .= sprintf('<div id="%s" class="tab-pane %s">%s</div><!-- .tab-pane -->', 'tab-'.$tab.'-'.$uniqeID, $class, ob_get_clean());

            $i++;
        }



        $output = sprintf('<div class="wc-products-tab-heading">%s</div><div class="tab-content">%s</div>', $heading.$tab_heading, $output_content);

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        $output = '<div class="'.esc_attr( $elementClass ).'"><div class="woocommerce  columns-' . $atts['columns'] . '">'.$output.'</div></div>';

        return $output;
    }
}



vc_map( array(
    "name" => esc_html__( "KT: Products Tab", 'wingman'),
    "base" => "products_tab",
    "category" => esc_html__('by Kite-Themes', 'wingman' ),
    "params" => array(

        // Data setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Data settings", 'wingman'),
            "param_name" => "data_settings",
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Data source", 'wingman'),
            "param_name" => "source",
            "value" => array(
                esc_html__('Widgets', 'wingman') => 'widgets',
                esc_html__('Specific Categories', 'wingman') => 'categories',
            ),
            'std' => 'widgets',
            "admin_label" => true,
            "description" => esc_html__("Select content type for your posts.", 'wingman'),
        ),

        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'product_cat',
            'heading' => esc_html__( 'Categories', 'js_composer' ),
            'param_name' => 'categories',
            'multiple' => true,
            'admin_label' => true,
            'select' => 'slug',
            "dependency" => array( "element" => "source","value" => 'categories' ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                '',
                esc_html__( 'Date', 'js_composer' ) => 'date',
                esc_html__( 'ID', 'js_composer' ) => 'ID',
                esc_html__( 'Author', 'js_composer' ) => 'author',
                esc_html__( 'Title', 'js_composer' ) => 'title',
                esc_html__( 'Modified', 'js_composer' ) => 'modified',
                esc_html__( 'Random', 'js_composer' ) => 'rand',
                esc_html__( 'Comment count', 'js_composer' ) => 'comment_count',
                esc_html__( 'Menu order', 'js_composer' ) => 'menu_order',
            ),
            'save_always' => true,
            "dependency" => array( "element" => "source","value" => 'categories' ),
            'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Sort order', 'js_composer' ),
            'param_name' => 'order',
            'value' => array(
                '',
                esc_html__( 'Descending', 'js_composer' ) => 'DESC',
                esc_html__( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'save_always' => true,
            "dependency" => array( "element" => "source","value" => 'categories' ),
            'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Products Layout", 'wingman'),
            "param_name" => "products_layout",
            "value" => array(
                esc_html__('Grid', 'wingman') => 'grid',
                esc_html__('Masonry', 'wingman') => 'masonry',
                esc_html__('Carousel', 'wingman') => 'carousel',
                esc_html__('Featured box', 'wingman') => 'featured',
            ),
            'std' => 'grid',
            "admin_label" => true,
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Columns', 'wingman' ),
            'param_name' => 'columns',
            'value' => array(
                esc_html__( '1 column', 'js_composer' ) => '1',
                esc_html__( '2 columns', 'js_composer' ) => '2',
                esc_html__( '3 columns', 'js_composer' ) => '3',
                esc_html__( '4 columns', 'js_composer' ) => '4',
                esc_html__( '6 columns', 'js_composer' ) => '6',
            ),
            'std' => '4',
            'dependency' => array(
                'element' => 'products_layout',
                'value' => array( 'grid', 'masonry' ),
            ),
            'description' => esc_html__('The columns attribute controls how many columns wide the products should be before wrapping.', 'mondova')
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Per page', 'js_composer' ),
            'value' => 8,
            'param_name' => 'per_page',
            'dependency' => array(
                'element' => 'products_layout',
                'value_not_equal_to' => 'featured',
            ),
            'description' => esc_html__( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Product hover effect", 'wingman'),
            "param_name" => "hover_effect",
            "value" => array(
                esc_html__('Effect 1', 'wingman') => '1',
                esc_html__('Effect 2', 'wingman') => '2',
                esc_html__('Effect 3', 'wingman') => '3',
            ),
            'std' => '1',
            "admin_label" => true,
        ),

        // Others setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Others settings", 'wingman'),
            "param_name" => "others_settings",
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Nav style', 'js_composer' ),
            'param_name' => 'nav',
            'value' => array(
                esc_html__( 'Style 1', 'js_composer' ) => '1',
                esc_html__( 'Style 2', 'js_composer' ) => '2',
                esc_html__( 'Style 3', 'js_composer' ) => '3',
                esc_html__( 'Style 4', 'js_composer' ) => '4'
            ),
            'description' => esc_html__( 'Select your style for nav.', 'mondova' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Nav Divider', 'js_composer' ),
            'param_name' => 'divider',
            'value' => array(
                esc_html__( 'None', 'js_composer' ) => '',
                esc_html__( 'Style 1', 'js_composer' ) => '1',
            ),
            'description' => esc_html__( 'Select your style for nav.', 'mondova' )
        ),


        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Heading Alignment', 'js_composer' ),
            'param_name' => 'align',
            'value' => array(
                esc_html__( 'Center', 'js_composer' ) => 'center',
                esc_html__( 'Left', 'js_composer' ) => 'left',
                esc_html__( 'Right', 'js_composer' ) => "right"
            ),
            'description' => esc_html__( 'Select separator alignment.', 'js_composer' )
        ),

        array(
            "type" => "kt_number",
            "heading" => esc_html__("Active section", 'wingman'),
            "param_name" => "active_section",
            "value" => "1",
            'description' => esc_html__( "Enter active section number (Note: to have all sections closed on initial load enter non-existing number).", 'mondova')
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'js_composer' ),
            'param_name' => 'css_animation',
            'admin_label' => true,
            'value' => array(
                esc_html__( 'No', 'js_composer' ) => '',
                esc_html__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
                esc_html__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
                esc_html__( 'Left to right', 'js_composer' ) => 'left-to-right',
                esc_html__( 'Right to left', 'js_composer' ) => 'right-to-left',
                esc_html__( 'Appear from center', 'js_composer' ) => "appear"
            ),
            'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),

        // Carousel Settings
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Columns to Show?", 'wingman'),
            "edit_field_class" => "kt_sub_heading vc_column",
            "param_name" => "items_show",
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'dependency' => array(
                'element' => 'products_layout',
                'value' => array( 'carousel' ),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'on Desktop', 'wingman' ),
            'param_name' => 'product_columns',
            'value' => array(
                esc_html__( '1 column', 'js_composer' ) => '1',
                esc_html__( '2 columns', 'js_composer' ) => '2',
                esc_html__( '3 columns', 'js_composer' ) => '3',
                esc_html__( '4 columns', 'js_composer' ) => '4',
                esc_html__( '6 columns', 'js_composer' ) => '6',
            ),
            'std' => '4',
            "edit_field_class" => "vc_col-sm-4 vc_column",
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'dependency' => array(
                'element' => 'products_layout',
                'value' => array( 'carousel' ),
            ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'on Tablets Landscape', 'wingman' ),
            'param_name' => 'product_columns_desktop',
            'value' => array(
                esc_html__( '1 column', 'js_composer' ) => '1',
                esc_html__( '2 columns', 'js_composer' ) => '2',
                esc_html__( '3 columns', 'js_composer' ) => '3',
                esc_html__( '4 columns', 'js_composer' ) => '4',
                esc_html__( '6 columns', 'js_composer' ) => '6',
            ),
            'std' => '3',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            "edit_field_class" => "vc_col-sm-4 vc_column",
            'dependency' => array(
                'element' => 'products_layout',
                'value' => array( 'carousel' ),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'on Tablet', 'wingman' ),
            'param_name' => 'product_columns_tablet',
            'value' => array(
                esc_html__( '1 column', 'js_composer' ) => '1',
                esc_html__( '2 columns', 'js_composer' ) => '2',
                esc_html__( '3 columns', 'js_composer' ) => '3',
                esc_html__( '4 columns', 'js_composer' ) => '4',
                esc_html__( '6 columns', 'js_composer' ) => '6',
            ),
            'std' => '2',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            "edit_field_class" => "vc_col-sm-4 vc_column",
            'dependency' => array(
                'element' => 'products_layout',
                'value' => array( 'carousel' ),
            ),
        ),



        // Heading setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Heading settings", 'wingman'),
            "param_name" => "heading_settings",
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Text', 'js_composer' ),
            'param_name' => 'text',
            'admin_label' => true,
            'value' => '',
            'description' => esc_html__( 'Note: If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'js_composer' ),
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            'type' => 'hidden',
            'heading' => esc_html__( 'URL (Link)', 'js_composer' ),
            'param_name' => 'link',
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Subtitle", 'wingman'),
            "param_name" => "subtitle",
            "value" => '',
            "description" => esc_html__("", 'wingman'),
            'admin_label' => true,
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Backend", 'wingman'),
            "param_name" => "backend",
            "value" => '',
            "description" => esc_html__("", 'wingman'),
            'admin_label' => true,
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'layout', 'js_composer' ),
            'param_name' => 'layout',
            'value' => array(
                esc_html__( 'Layout 1', 'js_composer' ) => "1",
                esc_html__( 'Layout 2', 'js_composer' ) => "2",
                esc_html__( 'Layout 3', 'js_composer' ) => "3",
            ),
            'admin_label' => true,
            'description' => esc_html__( 'Select your layout.', 'wingman' ),
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Typography heading", 'wingman'),
            "param_name" => "typography_heading",
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    'tag' => 'h2',
                    'color',
                    'font_size',
                    'line_height',
                    'tag_description' => esc_html__( 'Select element tag.', 'js_composer' ),
                    'text_align_description' => esc_html__( 'Select text alignment.', 'js_composer' ),
                    'font_size_description' => esc_html__( 'Enter font size.', 'js_composer' ),
                    'line_height_description' => esc_html__( 'Enter line height.', 'js_composer' ),
                    'color_description' => esc_html__( 'Select heading color.', 'js_composer' ),
                ),
            ),
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Use theme default font family?', 'js_composer' ),
            'param_name' => 'use_theme_fonts',
            'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' ),
            'description' => esc_html__( 'Use font family from the theme.', 'js_composer' ),
            'group' => esc_html__( 'Heading', 'wingman' ),
            'std' => 'yes'
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts',
            'value' => 'font_family:Oswald|font_style:700%20regular%3A400%3Anormal',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => esc_html__( 'Select font family.', 'js_composer' ),
                    'font_style_description' => esc_html__( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => esc_html__( 'Heading', 'wingman' ),
            'dependency' => array(
                'element' => 'use_theme_fonts',
                'value_not_equal_to' => 'yes',
            ),
        ),

        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Typography Sub title", 'wingman'),
            "param_name" => "typography_subtitle",
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container_subtitle',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    'color',
                    'font_size',
                    'color_description' => esc_html__( 'Select heading color.', 'js_composer' ),
                    'font_size_description' => esc_html__( 'Enter font size.', 'js_composer' ),
                ),
            ),
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),


        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Typography Backend", 'wingman'),
            "param_name" => "typography_backend",
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container_backend',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    'color',
                    'font_size',
                    'color_description' => esc_html__( 'Select heading color.', 'js_composer' ),
                    'font_size_description' => esc_html__( 'Enter font size.', 'js_composer' ),
                ),
            ),
            'group' => esc_html__( 'Heading', 'wingman' ),
        ),


        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => esc_html__( 'Design options', 'js_composer' )
        ),
    ),
));
