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
    }
endif;

/**
 * Add custom style to woocommerce
 *
 */
function kt_wp_enqueue_scripts(){
    wp_enqueue_style( 'kt-woocommerce', KT_THEME_CSS . 'woocommerce.css' );
    wp_enqueue_script( 'kt-woocommerce', KT_THEME_JS . 'woocommerce.js', array( 'jquery', 'jquery-ui-accordion', 'jquery-ui-tabs' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'kt_wp_enqueue_scripts' );



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
    if ( kt_is_wc() && defined( 'YITH_WOOCOMPARE' ) ) {
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
            <ul class="cart_list product_list_widget ">
            <?php
                $args = array( 'is_default' => 1 );
                $wishlist_items = $yith_wcwl->get_products($args);
                if( count( $wishlist_items ) > 0 ) {
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

                }else{
                    printf('<li class="cart-desc empty">%s</li>', esc_html__('Your wishlist is empty.', 'mondova') );
                }
            ?>
            </ul>
            <?php if( count( $wishlist_items ) > 0 ) { ?>
                <p class="buttons-wishlist">
                    <?php
                        printf(
                            '<span><a class="btn btn-default btn-block wc-forward" href="%s">%s</a></span>',
                            esc_url( $yith_wcwl->get_wishlist_url() ),
                            esc_html__('View Wishlist', 'mondova')
                        )
                    ?>
                </p>
            <?php } ?>
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
        if ( !is_cart() ) {
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
    function kt_cart_link() {
        printf(
            '<a href="%s" class="%s" title="%s">%s<span class="amount">%s</span></a>',
            esc_url( wc_get_page_permalink( 'cart' ) ),
            'cart-contents',
            esc_html__( 'View your shopping cart', 'delphinus' ),
            esc_html__('My cart', 'delphinus'),
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

        if(is_cart() || is_checkout() || is_account_page()){
            $sidebar['sidebar'] = '';
        }elseif(isset($_REQUEST['sidebar'])){
            $sidebar['sidebar'] = $_REQUEST['sidebar'];
            $sidebar['sidebar_area'] = 'shop-widget-area';
        }elseif(is_shop() || is_product_taxonomy() || is_product_tag()){
            $sidebar['sidebar'] = kt_option('shop_sidebar', 'left');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('shop_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('shop_sidebar_right', 'primary-widget-area');
            }
        }/*elseif(is_product() || $post_id){

            global $post;
            if(!$post_id) $post_id = $post->ID;
            $sidebar['sidebar'] = rwmb_meta('_kt_sidebar', array(), $post_id);

            if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default'){
                $sidebar['sidebar'] = kt_option('product_sidebar', 'full');
                if($sidebar['sidebar'] == 'left' ){
                    $sidebar['sidebar_area'] = kt_option('product_sidebar_left', 'primary-widget-area');
                }elseif($sidebar['sidebar'] == 'right'){
                    $sidebar['sidebar_area'] = kt_option('product_sidebar_right', 'primary-widget-area');
                }
            }elseif($sidebar['sidebar'] == 'left'){
                $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
            }

        }*/

        if($sidebar['sidebar'] == 'full'){
            $sidebar['sidebar'] = '';
        }

        return apply_filters('kt_wc_sidebar', $sidebar);
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
            <a class="grid<?php if($gridlist == 'grid'){ ?> active<?php } ?>" data-toggle="tooltip" href="#" title="<?php _e('Grid view', 'wingman') ?>" data-layout="products-grid" data-remove="products-list">
                <i class="fa fa-th"></i>
            </a>
        </li>
        <li>
            <a class="list<?php if($gridlist == 'list'){ ?> active<?php } ?>" data-toggle="tooltip" href="#" title="<?php _e('List view', 'wingman') ?>" data-layout="products-list" data-remove="products-grid">
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
        'menu_order' => __( 'Default sorting', 'mondova' ),
        'popularity' => __( 'Popularity', 'mondova' ),
        'rating'     => __( 'Average rating', 'mondova' ),
        'date'       => __( 'Newness', 'mondova' ),
        'price'      => __( 'Price: low to high', 'mondova' ),
        'price-desc' => __( 'Price: high to low', 'mondova' )
    );
}

function kt_woocommerce_shop_loop(){
    ?>
    <div class="products-tools">
        <?php
        woocommerce_result_count();
        woocommerce_catalog_ordering();
        kt_woocommerce_gridlist_toggle();

        ?>
    </div>
    <?php
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
    global $post, $product;
    if ( has_post_thumbnail() ) {
        echo get_the_post_thumbnail( $post->ID, 'shop_catalog', array('class'=>"first-img product-img"));
    } elseif ( wc_placeholder_img_src() ) {
        echo wc_placeholder_img( 'shop_catalog' );
    }

    $attachment_ids = $product->get_gallery_attachment_ids();
    if($attachment_ids){
        foreach ( $attachment_ids as $attachment_id ) {
            $image_link = wp_get_attachment_url( $attachment_id );
            if ( $image_link ){
                echo wp_get_attachment_image( $attachment_id, 'shop_catalog', false, array('class'=>"second-img product-img"));
                break;
            }
        }
    }
}

/**
 * Insert the opening anchor tag for products in the loop.
 */
function kt_template_loop_product_link_open() {
    global $product;
    $classes = array('product-thumbnail' );

    $attachment_ids = $product->get_gallery_attachment_ids();

    if($attachment_ids){
        $classes[] = 'product-thumbnail-effect';
    }

    printf(
        '<a class="%s" href="%s">',
        implode(' ',$classes),
        get_the_permalink()
    );
}


function kt_woocommerce_show_product_badge(){
    global $product, $post;

    $time_new = kt_option('time_product_new', 30);
    $now = strtotime( date("Y-m-d H:i:s") );
    $post_date = strtotime( $post->post_date );
    $num_day = (int)(($now - $post_date)/(3600*24));

    echo '<div class="product-badge">';
    if ( ! $product->is_in_stock() ) {
        printf('<span class="wc-out-of-stock">%s</span>', esc_html__( 'Out of stock', 'mondova' ));
    }elseif ( $product->is_on_sale() ){
	    echo apply_filters( 'woocommerce_sale_flash', '<span class="wc-onsale-badge">' . __( 'Sale!', 'mondova' ) . '</span>', $post, $product );
    }elseif( $num_day < $time_new ) {
        echo "<span class='wc-new-badge'>".esc_html__( 'New','wingman' )."</span>";
    }
    echo '</div>';

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
            esc_html__('Compare','wingman'),
            do_shortcode('[yith_compare_button container="no" type="link"]')
        );
    }

    printf(
        '<div data-toggle="tooltip" data-placement="top" title="'. esc_html__('Quick View','wingman').'"><a href="#" class="product-quick-view" data-id="%s">%s</a></div>',
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





function kt_template_product_actions(){

    echo "<div class='product-actions'>";

    if(class_exists('YITH_WCWL_UI')){
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    }

    if(defined( 'YITH_WOOCOMPARE' )){
        printf(
            '<div data-toggle="tooltip" data-placement="top" title="%s">%s</div>',
            esc_html__('Compare','wingman'),
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


/**
 * KT WooCommerce hooks
 *
 * @package mondova
 */

add_action( 'wp_ajax_fronted_get_wishlist', 'kt_fronted_fronted_get_wishlist' );
add_action( 'wp_ajax_nopriv_fronted_get_wishlist', 'kt_fronted_fronted_get_wishlist' );


if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
    add_filter( 'woocommerce_add_to_cart_fragments', 'kt_cart_link_fragment' );
} else {
    add_filter( 'add_to_cart_fragments', 'kt_cart_link_fragment' );
}

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



/**
 * KT WooCommerce Products hooks
 *
 * @package mondova
 */

add_filter('woocommerce_loop_add_to_cart_args', 'kt_loop_add_to_cart_args', 10, 2);


remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);




add_action( 'woocommerce_before_shop_loop', 'kt_woocommerce_shop_loop');

add_action('woocommerce_shop_loop_subcategory_title', 'kt_template_loop_category_title', 10);

add_action('woocommerce_shop_loop_item_title', 'kt_template_loop_product_title', 20);
add_action('woocommerce_before_shop_loop_item', 'kt_template_loop_product_link_open');
add_action('woocommerce_shop_loop_item_content', 'kt_template_loop_product_actions', 5);
add_action('woocommerce_shop_loop_item_content', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_before_shop_loop_item_title', 'kt_template_loop_product_thumbnail');
add_action('woocommerce_before_shop_loop_item', 'kt_woocommerce_show_product_badge', 5);

add_action('woocommerce_shop_loop_item_details', 'woocommerce_template_single_excerpt', 5);
add_action('woocommerce_shop_loop_item_details', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_shop_loop_item_details', 'kt_template_loop_product_actions', 15);




/**
 * KT WooCommerce Product detail
 *
 * @package mondova
 */





remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);


add_filter('woocommerce_product_description_heading', '__return_false');
add_filter('woocommerce_product_additional_information_heading', '__return_false');

add_action('woocommerce_product_images', 'kt_woocommerce_show_product_badge', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 2);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating_before', 9);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating_after', 12);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30);





add_action('woocommerce_after_add_to_cart_button', 'kt_template_product_actions');

add_action('woocommerce_share', 'kt_share_box');


