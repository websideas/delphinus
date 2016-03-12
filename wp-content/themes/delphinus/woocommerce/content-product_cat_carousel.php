<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


?>
<div class="category-banner">
    <?php
    /**
     * woocommerce_before_subcategory_title hook.
     *
     * @hooked woocommerce_subcategory_thumbnail - 10
     */
    do_action( 'woocommerce_before_subcategory_title', $category );

    ?>
    <div class="category-banner-content">
        <?php

        //print_r($category);

        printf('<h3>%s</h3>', $category->name);


        $args = array(
            'parent' => $category->term_id
        );
        $terms = get_terms( 'product_cat', $args );


        if(count($terms)){
            $terms_html = '';
            foreach($terms as $term){
                $terms_html .= sprintf(
                    '<li><a href="%s">%s</a></li>',
                    get_term_link( $category->slug, 'product_cat' ),
                    $term->name
                );
            }
            echo '<ul>'.$terms_html.'</ul>';
        }

        printf(
            '<a href="%s" class="%s">%s</a>',
            get_term_link( $category->slug, 'product_cat' ),
            'btn btn-light-b',
            esc_html__('Shop now', 'delphinus')
        );
        ?>
    </div>
</div>
