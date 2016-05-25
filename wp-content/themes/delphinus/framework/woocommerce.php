<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Enable support for woocommerce after setip theme
 *
 */
add_action( 'after_setup_theme', 'kt_woocommerce_theme_setup' );
if ( ! function_exists( 'kt_woocommerce_theme_setup' ) ):
    function kt_woocommerce_theme_setup() {
        /**
         * Enable support for woocommerce
         */
        add_theme_support( 'woocommerce' );

        if (function_exists( 'add_image_size' ) ) {
            add_image_size( 'kt_product', 270, 200, true);
            add_image_size( 'kt_landscape', 570, 200, true);
            add_image_size( 'kt_portrait', 200, 570, true);
            add_image_size( 'kt_wide', 570, 430, true);
            add_image_size( 'kt_big', 870, 430, true);
            add_image_size( 'kt_cate_carousel', 640, 800, true);

            add_image_size( 'kt_product_slider', 265, 375, true);
        }

    }
endif;


function kt_get_product_layout(){
    $layout = rwmb_meta('_kt_detail_layout', array(), get_the_ID());
    if(!$layout){
        $layout = kt_option('product_detail_layout','layout1');
    }
    return $layout;
}



add_action('woocommerce_widget_field_colors', 'kt_wc_widget_field_colors', 10, 4);
function kt_wc_widget_field_colors( $key, $value, $setting, $instance ){

    printf('<label>%s</label>', esc_html__('Select color bellow', 'delphinus'));

    $terms = get_terms( 'pa_color', array( 'hide_empty' => '0' ) );
    $rand = rand();

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        $output = sprintf( '<table class="colors-table"><tr><td><b>%s</b></td><td><b>%s</b></td></tr>', esc_html__( 'Term', 'delphinus' ), esc_html__( 'Color', 'delphinus' ) );
        foreach ( $terms as $term ) {
            $id = 'woocommerce_widget_field_colors' . $term->term_id;
            $output .= '<tr>
							<td><label for="' . esc_attr( $rand ) . '">' . esc_attr( $term->name ) . ' </label></td>
							<td><input type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $setting['name'] ) . '[' . esc_attr( $term->term_id ) . ']" value="' . ( isset( $value[$term->term_id] ) ? esc_attr( $value[$term->term_id] ) : '' ) . '" size="3" class="color-picker" /></td>
						</tr>';
        }

        $output .= '</table>';
    } else {
        $output = '<span>No product attribute saved with the <strong>"color"</strong> slug yet.</span>';
    }

    echo $output;

}



/**
 * Extend the default WordPress body classes.
 *
 * @since 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function kt_wc_body_classes( $classes ) {
    if(is_product()){
        $layout = kt_get_product_layout();
        $classes[] = 'product-'.$layout;
    }
    return $classes;
}



/**
 * Define image sizes
 *
 *
 */
function kt_woocommerce_set_option() {
    global $pagenow;

    if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
        return;
    }

    $catalog = array('width' => '600','height' => '600', 'crop' => 1 );
    $thumbnail = array('width' => '100', 'height' => '100', 'crop' => 1 );
    $single = array( 'width' => '1000','height' => '1000', 'crop' => 1);

    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
    update_option( 'shop_single_image_size', $single ); 		// Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs

}
add_action( 'after_switch_theme', 'kt_woocommerce_set_option', 1 );


/**
 * Woocommerce wishlist in header
 *
 * @since 1.0
 */
function kt_woocommerce_get_wishlist( ){
    if ( kt_is_wc() && defined( 'YITH_WCWL' ) ) {
        kt_cart_wishlist();
    }
}


/**
 * WishList Link
 * Displayed a link to the cart including the number of items present and the cart total
 * @param  array $settings Settings
 * @return array           Settings
 * @since  1.0.0
 */
if ( ! function_exists( 'kt_cart_wishlist' ) ) {
    function kt_cart_wishlist() {
        global $yith_wcwl;
        printf(
            '<a href="%s" class="%s" title="%s">%s<span class="amount">%s</span></a>',
            esc_url( $yith_wcwl->get_wishlist_url() ),
            'wishlist-contents',
            esc_html__( 'View your wishlist', 'delphinus' ),
            esc_html__('wishlist', 'delphinus'),
            $yith_wcwl->count_products()
        );
        ?>
        <div class="navigation-submenu shopping-bag-content woocommerce widget_shopping_cart">
            <?php
            $args = array( 'is_default' => 1 );
            $wishlist_items = $yith_wcwl->get_products($args);

            if( count( $wishlist_items ) > 0 ) {
                echo '<ul class="cart_list product_list_widget ">';
                    foreach( $wishlist_items as $item ) {
                        global $product;
                        if( function_exists( 'wc_get_product' ) ) {
                            $product = wc_get_product( $item['prod_id'] );
                        }
                        else{
                            $product = get_product( $item['prod_id'] );
                        }

                        if( $product !== false && $product->exists() ){
                            ?>
                            <li class="mini_cart_item">
                                <a class="minicart_product" href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item['prod_id'] ) ) ) ?>">
                                    <?php echo $product->get_image() ?>
                                    <?php echo apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ?>
                                </a>
                                <div class="minicart_product_infos">
                                    <?php
                                    if( is_a( $product, 'WC_Product_Bundle' ) ){
                                        if( $product->min_price != $product->max_price ){
                                            echo sprintf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
                                        }
                                        else{
                                            echo wc_price( $product->min_price );
                                        }
                                    }
                                    elseif( $product->price != '0' ) {
                                        echo $product->get_price_html();
                                    }
                                    else {
                                        echo apply_filters( 'yith_free_text', __( 'Free!', 'yith-woocommerce-wishlist' ) );
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    echo '</ul>';
                    printf(
                        '<p class="buttons-wishlist"><span><a class="btn btn-default btn-block wc-forward" href="%s">%s</a></span></p>',
                        esc_url( $yith_wcwl->get_wishlist_url() ),
                        esc_html__('View Wishlist', 'delphinus')
                    );
                }else{
                    printf('<p class="cart-desc empty">%s</p>', esc_html__('Your wishlist is empty.', 'delphinus') );

                }
            ?>
        </div>
        <?php
    }
}

/**
 * Woocommerce cart in header
 *
 * @since 1.0
 */
function kt_woocommerce_get_cart( ){
    if ( kt_is_wc() ) {
        kt_cart_link();
        if ( !is_cart() && !is_checkout()) {
            ?>
            <div class="navigation-submenu shopping-bag-content woocommerce widget_shopping_cart">
                <?php the_widget('WC_Widget_Cart', 'title='); ?>
            </div><!-- .shopping-bag-content -->
            <?php
        }
    }
}


/**
 * Cart Link
 * Displayed a link to the cart including the number of items present and the cart total
 * @param  array $settings Settings
 * @return array           Settings
 * @since  1.0.0
 */
if ( ! function_exists( 'kt_cart_link' ) ) {
    function kt_cart_link( $class = 'cart-contents', $text = null ) {
        if(!isset($text)){
            $text = esc_html__('My cart', 'delphinus');
        }
        printf(
            '<a href="%s" class="%s" title="%s">%s<span class="amount">%s</span></a>',
            esc_url( wc_get_page_permalink( 'cart' ) ),
            $class,
            esc_html__( 'View your shopping cart', 'delphinus' ),
            '<span>'.$text.'</span>',
            WC()->cart->get_cart_contents_count()
        );
    }
}


/**
 * Cart Fragments
 * Ensure cart contents update when products are added to the cart via AJAX
 * @param  array $fragments Fragments to refresh via AJAX
 * @return array            Fragments to refresh via AJAX
 */
if ( ! function_exists( 'kt_cart_link_fragment' ) ) {
    function kt_cart_link_fragment( $fragments ) {
        ob_start();
        kt_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        ob_start();
        kt_cart_link('cart-mobile', '<i class="kt-icon-Shopping-Cart"></i>');
        $fragments['a.cart-mobile'] = ob_get_clean();

        return $fragments;
    }
}
if (!function_exists('kt_template_loop_category_title')) {
    /**
     * Show the subcategory title in the product loop.
     */
    function kt_template_loop_category_title( $category )
    {
        ?>
        <h3 class="product-title">
            <?php
            echo '<a href="' . get_term_link( $category->slug, 'product_cat' ) . '">';
            echo $category->name;
            if ( $category->count > 0 )
                echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">(' . $category->count . ')</span>', $category );
            echo '</a>';
            ?>
        </h3>

        <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="shop-now-link">
            <?php echo esc_html__('Shop now', 'delphinus') ?>
        </a>

        <?php
    }
}



if (!function_exists('kt_get_woo_sidebar')) {
    /**
     * Get woo sidebar
     *
     * @param null $post_id
     * @return array
     */
    function kt_get_woo_sidebar( $post_id = null )
    {

        $sidebar = array('sidebar' => '', 'sidebar_area' => '');

        if(isset($_REQUEST['sidebar'])){
            $sidebar['sidebar'] = $_REQUEST['sidebar'];
            $sidebar['sidebar_area'] = 'shop-widget-area';
        }elseif(is_shop() || is_product_taxonomy() || is_product_tag()){
            $sidebar['sidebar'] = kt_option('shop_sidebar', 'left');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('shop_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('shop_sidebar_right', 'primary-widget-area');
            }
        }

        if($sidebar['sidebar'] == 'full'){
            $sidebar['sidebar'] = '';
        }

        return apply_filters('kt_wc_sidebar', $sidebar);
    }
}

if ( ! function_exists( 'kt_wc_subcategory_thumbnail' ) ) {

    /**
     * Show subcategory thumbnails.
     *
     * @param mixed $category
     * @subpackage	Loop
     */
    function kt_wc_subcategory_thumbnail( $category, $woocommerce_carousel ) {

        if($woocommerce_carousel == 'portrait'){
            $small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'kt_cate_carousel' );
        }else{
            $small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );

        }

        $dimensions    			= wc_get_image_size( $small_thumbnail_size );

        $thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

        if ( $thumbnail_id ) {
            $image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
            $image = $image[0];
        } else {
            $image = wc_placeholder_img_src();
        }

        if ( $image ) {
            // Prevent esc_url from breaking spaces in urls for image embeds
            // Ref: http://core.trac.wordpress.org/ticket/23605
            $image = str_replace( ' ', '%20', $image );

            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
        }
    }
}

/**
 * Display Gird List toogle
 *
 *
 */

function kt_woocommerce_gridlist_toggle(){ ?>
    <?php $gridlist = apply_filters('woocommerce_gridlist_toggle', kt_get_gridlist_toggle()) ?>
    <ul class="gridlist-toggle">
        <li>
            <a class="grid<?php if($gridlist == 'grid'){ ?> active<?php } ?>" data-toggle="tooltip" href="#" title="<?php _e('Grid view', 'delphinus') ?>" data-layout="products-grid" data-remove="products-list">
                <i class="fa fa-th"></i>
            </a>
        </li>
        <li>
            <a class="list<?php if($gridlist == 'list'){ ?> active<?php } ?>" data-toggle="tooltip" href="#" title="<?php _e('List view', 'delphinus') ?>" data-layout="products-list" data-remove="products-grid">
                <i class="fa fa-bars"></i>
            </a>
        </li>
    </ul>
<?php }


/**
 * Get Grid or List layout.
 *
 * Return the layout of products
 *
 * @return string layout of products.
 *
 *
 */
function kt_get_gridlist_toggle( $layout = 'grid' ){
    if(isset($_REQUEST['view'])){
        return $_REQUEST['view'];
    }else{
        return kt_option('shop_products_layout', $layout);
    }
}




add_filter( 'kt_product_loop_start', 'kt_wc_product_loop_start' );
function kt_wc_product_loop_start($classes){
    if(is_product_category() || is_shop() || is_product_tag()){
        $view = kt_get_gridlist_toggle();
        $classes .= ' products-'.$view;
    }
    return $classes;
}










if ( !function_exists('kt_product_shop_count') ) {
    function kt_product_shop_count() {
        $default_count = $products_per_page = kt_option('products_per_page', 12);
        $count = isset($_GET['per_page']) ? $_GET['per_page'] : $default_count;
        if ( $count === 'all' ) {
            $count = -1;
        } else if ( !is_numeric($count) ) {
            $count = $default_count;
        }
        return $count;
    }
}


function kt_woocommerce_catalog_orderby( ){
    return array(
        'menu_order' => __( 'Default sorting', 'delphinus' ),
        'popularity' => __( 'Popularity', 'delphinus' ),
        'rating'     => __( 'Average rating', 'delphinus' ),
        'date'       => __( 'Newness', 'delphinus' ),
        'price'      => __( 'Price: low to high', 'delphinus' ),
        'price-desc' => __( 'Price: high to low', 'delphinus' )
    );
}


/*
 *	Create single category list HTML
 */
function kt_category_list_item( $category, $current_cat ) {

    $active = ( $current_cat == $category->term_id ) ? 'current-cat ' : '';
    $output = sprintf('<li class="%s"><a href="%s">%s</a></li>', $active.'cat-item-' . $category->term_id, esc_url( get_term_link( (int) $category->term_id, 'product_cat' ) ), $category->name);

    return $output;
}

/*
 *	Output product categories menu
 */
function kt_category_menu( ) {
    global $wp_query;

    $page_id = wc_get_page_id( 'shop' );
    $current_cat = ( is_product_category( ) ) ? $wp_query->queried_object->term_id : '';


    $page_url = get_permalink( $page_id );
    $hide_sub = true;
    $all_categories_class = '';


    if ( is_product_category() ) {
        $hide_sub = false;

        $direct_children = get_terms( 'product_cat',
            array(
                'fields'       	=> 'ids',
                'parent'       	=> $current_cat,
                'hierarchical'	=> true,
                'hide_empty'   	=> false
            )
        );

        $category_has_children = ( empty( $direct_children ) ) ? false : true;
    } else {
        if ( ! is_product_tag() && ! isset( $_REQUEST['s'] ) ) {
            $all_categories_class = ' class="current-cat"';
        }
    }

    $output = '<li' . $all_categories_class . '><a href="' . esc_url ( $page_url ) . '">' . esc_html__( 'All', 'delphinus' ) . '</a></li>';
    $sub_output = '';

    $orderby = kt_option('shop_header_orderby', 'slug');
    $order = kt_option('shop_header_order', 'ASC');

    $categories = get_categories( $args = array(
        'type'			=> 'post',
        'orderby'		=> $orderby,
        'order'			=> $order,
        'hide_empty'	=> 0,
        'hierarchical'	=> 1,
        'taxonomy'		=> 'product_cat'
    ) );

    foreach( $categories as $category ) {
        if ( $category->parent != '0' ) {
            if ( $hide_sub ) {
                continue;
            } else {
                if (
                    $category->term_id == $current_cat || // Include current sub-category
                    $category->parent == $current_cat || // Include current sub-category's children
                    ! $category_has_children && $category->parent == $wp_query->queried_object->parent // Include categories with the same parent (if current sub-category doesn't have children)
                ) {
                    $sub_output .= kt_category_list_item( $category, $current_cat );
                }
                continue;
            }
        }

        $output .= kt_category_list_item( $category, $current_cat );
    }

    if ( strlen( $sub_output ) > 0 ) {
        $sub_output = '<ul class="shop-header-list shop-header-sub">' . $sub_output . '</ul>';
    }
    $shop_header_filters = '';


    $search = kt_option('shop_header_search', 1);
    if($search){
        $shop_header_filters .= '<li class="wc-header-search">'.get_product_search_form(false).'</li>';
    }

    $shop_header_filters .= sprintf('<li class="wc-header-categories"><a href="#kt-shop-categories">%s</a></li>', esc_html__('Categories', 'delphinus'));




    $filters = kt_option('shop_header_filters', 1);
    $filters_html = '';
    if($filters){
        $shop_header_filters .= sprintf('<li class="wc-header-filter"><a href="#kt-shop-filters">%s</a></li>', esc_html__('Filter', 'delphinus'));

        ob_start();

        echo '<div class="clearfix"></div><div id="kt-shop-filters" class="row multi-columns-row"><div id="kt-shop-filters-content">';
        dynamic_sidebar('shop-filter-area');
        echo '</div></div>';

        $filters_html = ob_get_clean();

    }


    if($shop_header_filters){
        $shop_header_filters = '<div class="shop-header-right"><ul class="shop-header-list">'.$shop_header_filters.'</ul></div>';
    }


    echo $shop_header_filters.'<div class="shop-header-left"><ul id="shop-header-categories" class="shop-header-list">'.$output.'</ul>' . $sub_output .'</div>'.$filters_html;



}



function kt_woocommerce_shop_loop(){
    $shop_header_tool_bar = kt_option('shop_header_tool_bar', 1);
    if($shop_header_tool_bar){

        if($shop_header_tool_bar == 2){
            echo '<div class="products-shop-header">';
            kt_category_menu();
            echo '</div>';
        }else{
            echo '<div class="products-tools">';
            woocommerce_result_count();
            woocommerce_catalog_ordering();
            kt_woocommerce_gridlist_toggle();
            echo '</div>';
        }
    }
}


/**
 * Change columns of shop
 *
 */

add_filter( 'loop_shop_columns', 'kt_woo_shop_columns' );
function kt_woo_shop_columns( $columns ) {
    $cols =  kt_option('shop_gird_cols', 3);
    if(isset($_REQUEST['cols'])){
        $cols = $_REQUEST['cols'];
    }

    return $cols ;
}



function kt_template_loop_product_thumbnail(){
    global $product, $woocommerce_loop;

    $image_size = 'shop_catalog';
    $type = $woocommerce_loop['type'];

    if($type == 'masonry'){
        $box_size = get_post_meta($product->id, '_kt_box_size', true);
        if($box_size == 'wide'){
            $image_size = 'kt_wide';
        }elseif($box_size == 'landscape'){
            $image_size = 'kt_landscape';
        }elseif($box_size == 'big'){
            $image_size = 'kt_big';
        }elseif( $box_size == 'portrait'){
            $image_size = 'kt_portrait';
        }else{
            $image_size = 'kt_product';
        }
    }elseif($type == 'slider'){
        $image_size = 'kt_product_slider';
        echo '<ul class="cd-item-wrapper">';
    }elseif($type == 'countdown'){
        $image_size = 'kt_wide';
    }

    $thumbnail = '';


    if($woocommerce_loop['type'] == 'transparent') {
        $thumbnail_product = kt_get_single_file('_kt_image', $image_size, $product->id);
        if($thumbnail_product){
            @list( $width, $height ) = getimagesize( $thumbnail_product['url'] );
            $thumbnail = '<img src="' . $thumbnail_product['url'] . '" alt="' . esc_attr(get_the_title()) . '" width="' . esc_attr( $width ) . '" class="wp-post-image" height="' . esc_attr( $height ) . '" />';
        }
    }

    if(!$thumbnail){
        if ( has_post_thumbnail() ) {
            $thumbnail = get_the_post_thumbnail( $product->id, $image_size, array('class'=>"first-img product-img"));
        } elseif ( wc_placeholder_img_src() ) {
            $thumbnail = wc_placeholder_img( $image_size );
        }
        if($type == 'slider'){
            $thumbnail = '<li class="selected">'.$thumbnail.'</li>';
        }
    }



    echo $thumbnail;

    if($type == 'classic' || $type == 'slider'){
        $attachment_ids = $product->get_gallery_attachment_ids();
        if($attachment_ids){
            $i = 1;
            foreach ( $attachment_ids as $attachment_id ) {
                //$image_link = wp_get_attachment_url( $attachment_id );

                if ( $type == 'classic' ){
                    echo wp_get_attachment_image( $attachment_id, $image_size, false, array('class'=>"second-img product-img"));
                    break;
                }elseif( $type == 'slider'){
                    $class = ($i == 1) ? 'move-right' : '';
                    echo '<li class="'.$class.'">'.wp_get_attachment_image( $attachment_id, $image_size, false, array('class'=>"product-img")).'</li>';
                }
                $i++;
            }
        }
    }
}

/**
 * Insert the opening anchor tag for products in the loop.
 */
function kt_template_loop_product_link_open() {
    global $product, $woocommerce_loop;
    $classes = array('product-thumbnail' );


    if($woocommerce_loop['type'] == 'classic') {
        $attachment_ids = $product->get_gallery_attachment_ids();
        if ($attachment_ids) {
            $classes[] = 'product-thumbnail-effect';
        }
    }

    if($woocommerce_loop['type'] == 'slider'){
        return;
    }

    printf(
        '<a class="%s" href="%s">',
        implode(' ',$classes),
        get_the_permalink()
    );
}


function kt_template_loop_product_link_close(){
    global $woocommerce_loop;
    if($woocommerce_loop['type'] != 'slider'){
        echo '</a>';
    }
}

function kt_template_loop_rating(){
    global $woocommerce_loop;
    if($woocommerce_loop['type'] == 'transparent' || $woocommerce_loop['type'] == 'mini') {
        wc_get_template('loop/rating.php');
    }
}


function kt_woocommerce_show_product_badge(){
    global $product, $post, $woocommerce_loop;

    if($woocommerce_loop['type'] == 'transparent' || $woocommerce_loop['type'] == 'mini') {
        return;
    }

    $time_new = kt_option('time_product_new', 30);
    $now = strtotime( date("Y-m-d H:i:s") );
    $post_date = strtotime( $post->post_date );
    $num_day = (int)(($now - $post_date)/(3600*24));
    $badge = '';

    if ( ! $product->is_in_stock() ) {
        $badge = sprintf('<span class="wc-out-of-stock">%s</span>', esc_html__( 'Sold out', 'delphinus' ));
    }elseif ( $product->is_on_sale() ){
        $badge =  apply_filters( 'woocommerce_sale_flash', '<span class="wc-onsale-badge">' . __( 'Sale!', 'delphinus' ) . '</span>', $post, $product );
    }elseif( $num_day < $time_new ) {
        $badge =  "<span class='wc-new-badge'>".esc_html__( 'New','delphinus' )."</span>";
    }

    if($badge){
        echo '<div class="product-badge">'.$badge.'</div>';
    }

}

if (  ! function_exists( 'kt_template_loop_product_title' ) ) {

    /**
     * Show the product title in the product loop. By default this is an H3.
     */
    function kt_template_loop_product_title() {
        printf('<h3 class="product-title"><a href="%s">%s</a></h3>', get_the_permalink(), get_the_title());
    }
}


function kt_template_loop_product_actions(){

    echo "<div class='product-actions'>";

    if(class_exists('YITH_WCWL_UI')){
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    }

    if(defined( 'YITH_WOOCOMPARE' )){
        printf(
            '<div data-toggle="tooltip" data-placement="top" title="%s">%s</div>',
            esc_html__('Compare','delphinus'),
            do_shortcode('[yith_compare_button container="no" type="link"]')
        );
    }

    printf(
        '<div data-toggle="tooltip" data-placement="top" title="'. esc_html__('Quick View','delphinus').'"><a href="#" class="product-quick-view" data-id="%s">%s</a></div>',
        get_the_ID(),
        '<i class="fa fa-search"></i>'
    );
    echo "</div>";
}


function kt_loop_add_to_cart_args($args, $product){
    $args['class']  = implode( ' ', array_filter( array(
        'btn',
        'product_type_' . $product->product_type,
        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
    ) ) );
    return $args;
}


function kt_fronted_fronted_get_wishlist() {
    ob_start();
    kt_cart_wishlist();
    $data['html'] = ob_get_clean();
    wp_send_json( $data );
}


function kt_woocommerce_template_single_excerpt(){

    global $post;

    $post_custom_excerpt = get_post_meta($post->ID, '_kt_short_description', true);

    if($post_custom_excerpt){
        $post_excerpt = $post_custom_excerpt;
    }else{
        $post_excerpt = $post->post_excerpt;
    }

    if ( ! $post_excerpt) {
        return;
    }
    echo apply_filters( 'woocommerce_short_description', $post_excerpt );
    
}


function kt_template_product_actions(){

    echo "<div class='product-actions'>";

    if(class_exists('YITH_WCWL_UI')){
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    }

    if(defined( 'YITH_WOOCOMPARE' )){
        printf(
            '<div data-toggle="tooltip" class="compare-action" data-placement="top" title="%s">%s</div>',
            esc_html__('Compare','delphinus'),
            do_shortcode('[yith_compare_button container="no" type="link"]')
        );
    }

    echo "</div>";
}

function kt_remove_yith_wcwl_positions($positions){
    $positions['add-to-cart']['hook'] = '';
    return $positions;
}



function kt_change_breadcrumb_delimiter( $defaults ) {
    $defaults['delimiter'] = '<span class="delimiter">/</span>';
    return $defaults;
}


function woocommerce_template_single_rating_before(){
    echo '<div class="product-price-wrap clearfix">';
}

function woocommerce_template_single_rating_after(){
    echo '</div>';
}














function woocommerce_after_shop_loop_item_sale_sale_price($product = false, $post = false){

    $product_id = 0;
    if( is_object( $product ) ){
        $product_id = $product->id;
    }elseif( is_object( $post) ){
        $product_id = $post->ID;
    }else{
        global $post;
        $product_id =  $post->ID;
    }

    if( ! $product_id  ){
        return;
    }

    $cache_key = 'time_sale_price_'.$product_id;
    $cache = wp_cache_get($cache_key);
    if( $cache ){
        echo $cache;
        return;
    }
    // Get variations
    $args = array(
        'post_type'     => 'product_variation',
        'post_status'   => array( 'private', 'publish' ),
        'numberposts'   => -1,
        'orderby'       => 'menu_order',
        'order'         => 'asc',
        'post_parent'   => $product_id
    );
    $variations = get_posts( $args );
    $variation_ids = array();
    if( $variations ){
        foreach ( $variations as $variation ) {
            $variation_ids[]  = $variation->ID;
        }
    }
    $sale_price_dates_to = false;

    if( !empty(  $variation_ids )   ){
        global $wpdb;
        $sale_price_dates_to = $wpdb->get_var( "
            SELECT
            meta_value
            FROM $wpdb->postmeta
            WHERE meta_key = '_sale_price_dates_to' and post_id IN(".join(',',$variation_ids).")
            ORDER BY meta_value DESC
            LIMIT 1
        " );

        if( $sale_price_dates_to !='' ){
            $sale_price_dates_to = date('Y-m-d', $sale_price_dates_to);
        }
    }

    if( !$sale_price_dates_to ){
        $sale_price_dates_to 	= ( $date = get_post_meta( $product_id, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
    }

    if($sale_price_dates_to){
        $cache = '<div class="woocommerce-countdown" data-time="'.$sale_price_dates_to.'"></div>';
        wp_cache_add( $cache_key, $cache );
        echo $cache;
    }else{
        wp_cache_delete( $cache_key );
    }
}


/**
 * Product Quick View callback AJAX request
 *
 */

function kt_frontend_product_quick_view_callback() {
    global $product, $post;
    $product_id = intval($_POST["product_id"]);
    $post = get_post( $product_id );
    $product = wc_get_product( $product_id );
    wc_get_template( 'content-single-product-quick-view.php');
    die();
}

/**
 * KT WooCommerce hooks
 *
 * @package delphinus
 */

add_action( 'wp_ajax_fronted_get_wishlist', 'kt_fronted_fronted_get_wishlist' );
add_action( 'wp_ajax_nopriv_fronted_get_wishlist', 'kt_fronted_fronted_get_wishlist' );


if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
    add_filter( 'woocommerce_add_to_cart_fragments', 'kt_cart_link_fragment' );
} else {
    add_filter( 'add_to_cart_fragments', 'kt_cart_link_fragment' );
}


add_filter( 'body_class', 'kt_wc_body_classes' );
add_filter( 'loop_shop_columns', 'kt_woo_shop_columns' );
add_filter( 'loop_shop_per_page', 'kt_product_shop_count');
add_filter( 'woocommerce_catalog_orderby', 'kt_woocommerce_catalog_orderby');
add_filter( 'woocommerce_show_page_title', '__return_false');
add_filter( 'woocommerce_product_loop_start', 'kt_woocommerce_product_loop_start_callback' );
add_filter( 'woocommerce_breadcrumb_defaults', 'kt_change_breadcrumb_delimiter' );


// Remove compare product
if(defined( 'YITH_WOOCOMPARE' )){
    global $yith_woocompare;
    remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
}

// Remove wishlist product
add_filter('yith_wcwl_positions', 'kt_remove_yith_wcwl_positions');

function kt_woocommerce_close_quickview(){
    echo '<a class="close-quickview" href="#"><i class="fa fa-times"></i></a>';
}


/**
 * KT WooCommerce Products hooks
 *
 * @package delphinus
 */

add_filter('woocommerce_loop_add_to_cart_args', 'kt_loop_add_to_cart_args', 10, 2);


remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);


add_action( 'kt_wc_subcategory_thumbnail', 'kt_wc_subcategory_thumbnail', 10, 2);

add_action( 'woocommerce_before_shop_loop', 'kt_woocommerce_shop_loop');

add_action('woocommerce_shop_loop_subcategory_title', 'kt_template_loop_category_title', 10);

add_action('woocommerce_shop_loop_item_title', 'kt_template_loop_product_title', 20);
add_action('woocommerce_before_shop_loop_item', 'kt_template_loop_product_link_open');
add_action('woocommerce_shop_loop_item_content', 'kt_template_loop_product_actions', 5);
add_action('woocommerce_shop_loop_item_content', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_before_shop_loop_item_title', 'kt_template_loop_product_thumbnail');
add_action('woocommerce_before_shop_loop_item', 'kt_woocommerce_show_product_badge', 5);

add_action('woocommerce_after_shop_loop_item', 'kt_template_loop_product_link_close');

add_action('woocommerce_shop_loop_item_details', 'kt_woocommerce_template_single_excerpt', 5);
add_action('woocommerce_shop_loop_item_details', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_shop_loop_item_details', 'kt_template_loop_product_actions', 15);

add_action('woocommerce_after_shop_loop_item_title', 'kt_template_loop_rating', 15);

add_action('woocommerce_after_shop_loop_item_sale', 'woocommerce_template_loop_rating', 5);
add_action( 'woocommerce_after_shop_loop_item_sale', 'woocommerce_after_shop_loop_item_sale_sale_price', 10, 2);


add_action( 'wp_ajax_frontend_product_quick_view', 'kt_frontend_product_quick_view_callback' );
add_action( 'wp_ajax_nopriv_frontend_product_quick_view', 'kt_frontend_product_quick_view_callback' );


/**
 * KT WooCommerce Product detail
 *
 * @package delphinus
 */


remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);


add_filter('woocommerce_product_description_heading', '__return_false');
add_filter('woocommerce_product_additional_information_heading', '__return_false');

add_action('woocommerce_product_images', 'kt_woocommerce_show_product_badge', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 2);
add_action('woocommerce_single_product_summary', 'kt_woocommerce_close_quickview', 2);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating_before', 9);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating_after', 12);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30);

add_action('woocommerce_after_add_to_cart_button', 'kt_template_product_actions');
add_action('woocommerce_share', 'kt_share_box');


/**
 * KT WooCommerce Cart & Checkout
 *
 * @package delphinus
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
