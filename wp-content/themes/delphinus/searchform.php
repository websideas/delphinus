<?php
/**
 * Template for displaying search forms
 *
 */
?>

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="screen-reader-text"><?php _e( 'Search for:', 'mondova' ); ?></label>
    <input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'mondova' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'mondova' ); ?>" />
    <button class="submit">
        <i class="icon_search"></i>
        <span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'mondova' ); ?></span>
    </button>
</form>
