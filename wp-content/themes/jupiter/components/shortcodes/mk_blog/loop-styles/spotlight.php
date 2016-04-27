<?php
global $mk_options;

switch ($view_params['column']) {
    case 1:
        if ($view_params['layout'] == 'full') {
            $image_width = round($mk_options['grid_width']);
        } 
        else {
            $image_width = round((($mk_options['content_width'] / 100) * $mk_options['grid_width']));
        }
        $mk_column_css = 'one-column';
        break;

    case 2:
        if ($view_params['layout'] == 'full') {
            $image_width = round($mk_options['grid_width'] / 2);
        } 
        else {
            $image_width = round((($mk_options['content_width'] / 100) * $mk_options['grid_width']) / 2);
        }
        $mk_column_css = 'two-column';
        break;

    case 3:
        $image_width = $mk_options['grid_width'] / 3;
        $mk_column_css = 'three-column';
        break;

    case 4:
        $image_width = $mk_options['grid_width'] / 4;
        $mk_column_css = 'four-column';
        break;

    default:
        $image_width = $mk_options['grid_width'] / 3;
        $mk_column_css = 'three-column';
        break;
}
    $image_height = $view_params['grid_image_height'];

    $post_type = get_post_meta($post->ID, '_single_post_type', true);
    $post_type = !empty($post_type) ? $post_type : 'image';

    $attachment_id = mk_get_blog_post_thumbnail($post_type);



    if ($view_params['image_size'] == 'crop') {
        $image_src_array = wp_get_attachment_image_src($attachment_id, 'full', true); 
        $image_output_src = mk_image_generator($image_src_array[0], $image_width, $image_height);
    } 
    else {
        if(!empty($attachment_id) && !mk_is_default_thumbnail(wp_get_attachment_image_src($attachment_id, 'full', true)[0])) {
            $image_src_array = wp_get_attachment_image_src($attachment_id , $view_params['image_size'], true); 
            $image_output_src = $image_src_array[0];
            $image_width = $image_src_array[1];
            $image_height = $image_src_array[2];    
        } else {
            $image_output_src = mk_image_generator('', $image_width, $image_height);
        }
    }


//if (!empty($attachment_id)) {
   
    $output = '<article id="' . get_the_ID() . '" class="mk-blog-spotlight-item '.$post_type.'-post-type mk-isotop-item ' . $mk_column_css . ' ' . $post_type . '-post-type">' . "\n";
    $output.= '<div class="featured-image">';
    $output.= '<img alt="' . get_the_title() . '" title="' . get_the_title() . '" src="' . $image_output_src . '" itemprop="image" />';
    $output.= '<div class="image-hover-overlay"></div>';
    
    // start:[item-wrapper]
    $output.= '<div class="item-wrapper">';
    
        // start:[mk-blog-meta]
        $output.= '<div class="mk-blog-meta">';
        $output.= mk_get_shortcode_view('mk_blog', 'components/meta', true, ['author' => 'false', 'cats' => 'false']);                                        
        $output.= mk_get_shortcode_view('mk_blog', 'components/title', true);
        $output.= do_shortcode('[mk_button dimension="outline" corner_style="pointed" outline_skin="light" size="medium" align="center" url="' . get_permalink() . '"]' . __('READ MORE', 'mk_framework') . '[/mk_button]');
        $output.= '</div>';
        // end:[mk-blog-meta]

        $output.= '</div>';
        // end:[item-wrapper]

    $output.= '</div>';
    // end:[featured-image]

    $output.= '</article>' . "\n\n\n";

    echo $output;
//}
