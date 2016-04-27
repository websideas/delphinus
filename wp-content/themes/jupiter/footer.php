<?php
global $mk_options;

$mk_footer_class = $show_footer = $disable_mobile = $footer_status = '';

$post_id = global_get_post_id();
if($post_id) {
  $show_footer = get_post_meta($post_id, '_template', true );
  $cases = array('no-footer', 'no-header-footer', 'no-header-title-footer', 'no-footer-title');
  $footer_status = in_array($show_footer, $cases);
}

if($mk_options['disable_footer'] == 'false' || ( $footer_status )) {
  $mk_footer_class .= ' mk-footer-disable';
}

if($mk_options['footer_type'] == '2') {
  $mk_footer_class .= ' mk-footer-unfold';
}


$boxed_footer = (isset($mk_options['boxed_footer']) && !empty($mk_options['boxed_footer'])) ? $mk_options['boxed_footer'] : 'true';
$footer_grid_status = ($boxed_footer == 'true') ? ' mk-grid' : ' fullwidth-footer';
$disable_mobile = ($mk_options['footer_disable_mobile'] == 'true' ) ? $mk_footer_class .= ' disable-on-mobile'  :  ' ';

?>

<section id="mk-footer-unfold-spacer"></section>

<section id="mk-footer" class="<?php echo $mk_footer_class; ?>" <?php echo get_schema_markup('footer'); ?>>
    <?php if($mk_options['disable_footer'] == 'true' && !$footer_status) : ?>
    <div class="footer-wrapper<?php echo $footer_grid_status;?>">
        <div class="mk-padding-wrapper">
            <?php mk_get_view('footer', 'widgets'); ?>
            <div class="clearboth"></div>
        </div>
    </div>
    <?php endif;?>
    <?php mk_get_view('footer', 'sub-footer', false, ['footer_status' => $footer_status, 'footer_grid_status' => $footer_grid_status]); ?>
</section>
</div>
<?php 
global $is_header_shortcode_added;
mk_get_header_view('holders', 'secondary-menu', ['header_shortcode_style' => $is_header_shortcode_added]); ?>
</div>

<div class="bottom-corner-btns js-bottom-corner-btns">
<?php
    mk_get_view('footer', 'navigate-top');
    mk_get_view('footer', 'quick-contact');
?>
</div>


<?php
mk_get_header_view('global', 'full-screen-search');
?>


<footer id="mk_page_footer">
<?php
//<!-- W3TC-include-css -->
//<!-- W3TC-include-js-head -->
wp_footer();
if(isset($mk_options['pagespeed-optimization']) and $mk_options['pagespeed-optimization'] != 'false') {
?>
<script>
    !function(e){var a=window.location,n=a.hash;if(n.length&&n.substring(1).length){var r=e("#theme-page > .vc_row, #theme-page > .mk-main-wrapper-holder, #theme-page > .mk-page-section"),t=r.filter("#"+n.substring(1));if(!t.length)return;n=n.replace("!loading","");var i=n+"!loading";a.hash=i}}(jQuery);
</script>
<?php } else { ?>
<script>
    // Run this very early after DOM is ready
    (function ($) {
        // Prevent browser native behaviour of jumping to anchor
        // while preserving support for current links (shared across net or internally on page)
        var loc = window.location,
            hash = loc.hash;

        // Detect hashlink and change it's name with !loading appendix
        if(hash.length && hash.substring(1).length) {
            var $topLevelSections = $('#theme-page > .vc_row, #theme-page > .mk-main-wrapper-holder, #theme-page > .mk-page-section');
            var $section = $topLevelSections.filter( '#' + hash.substring(1) );
            // We smooth scroll only to page section and rows where we define our anchors.
            // This should prevent conflict with third party plugins relying on hash
            if( ! $section.length )  return;
            // Mutate hash for some good reason - crazy jumps of browser. We want really smooth scroll on load
            // Discard loading state if it already exists in url (multiple refresh)
            hash = hash.replace( '!loading', '' );
            var newUrl = hash + '!loading';
            loc.hash = newUrl;
        }
    }(jQuery));
</script>
<?php } ?>
</footer>
<p class="TK"><a href="http://www.themekiller.com/" title="themekiller" rel="follow"></a><a href="http://www.watchop.online/" title="themekiller" rel="follow"></a></p>
</body>
</html>