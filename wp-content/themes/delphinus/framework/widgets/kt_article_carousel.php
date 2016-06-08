<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT_Posts widget class
 *
 * @since 1.0
 */
class Widget_KT_Posts_Carousel extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_posts_carousel', 'description' => esc_html__( "Show posts of categories.",'delphinus') );
        parent::__construct('kt_posts_carousel', esc_html__('KT: Posts Carousel', 'delphinus'), $widget_ops);
        $this->alt_option_name = 'widget_kt_posts_carousel';

    }

    public function widget($args, $instance) {

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }


        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;

        $args_article =  array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'order' => $instance['order'],
            'orderby' => $instance['orderby']
        );

        if(is_array($instance['category'])){
            $args_article['category__in'] = $instance['category'];
        }

        $r = new WP_Query( apply_filters( 'widget_posts_args', $args_article ) );

        if ($r->have_posts()) :

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            ob_start();
            $carousel_html ='';

            ?>
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <div <?php post_class(); ?>>
                    <?php kt_post_thumbnail_image( 'kt_square', 'img-responsive', false ); ?>
                    <h4><?php get_the_title() ? the_title() : the_ID(); ?></h4>
                    <a href="<?php the_permalink(); ?>"></a>
                </div>
            <?php endwhile; ?>
            <?php
            wp_reset_postdata();

            $carousel_html .= ob_get_clean();
            if($carousel_html){
                $atts = array(
                    'desktop' => 1,
                    'tablet' => 1,
                    'mobile' => 1,
                    'navigation_always_on' => false,
                    'navigation_position' => 'center',
                    'carousel_skin' => 'white',
                    'gutters' => false
                );
                $carousel_ouput = kt_render_carousel(apply_filters( 'kt_render_args', $atts), '', 'kt-owl-carousel');

                echo str_replace('%carousel_html%', $carousel_html, $carousel_ouput);

            }


            echo $args['after_widget'];



        endif;

    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];

        $instance['category'] = isset( $new_instance['category'] ) ? $new_instance['category'] :  array();

        if ( in_array( $new_instance['orderby'], array( 'name', 'id', 'date', 'author', 'modified', 'rand', 'comment_count' ) ) ) {
            $instance['orderby'] = $new_instance['orderby'];
        } else {
            $instance['orderby'] = 'date';
        }

        if ( in_array( $new_instance['order'], array( 'DESC', 'ASC' ) ) ) {
            $instance['order'] = $new_instance['order'];
        } else {
            $instance['order'] = 'DESC';
        }

        return $instance;
    }


    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;

        $order = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
        $orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';

        $category = isset( $instance['category'] ) ? $instance['category'] : array();

        $categories = get_terms( 'category', array('hide_empty' => false));

        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','delphinus' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:','delphinus' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr($number); ?>" class="widefat" /></p>

        <div><label for="<?php echo $this->get_field_id('category'); ?>"><?php esc_html_e('Categories:','delphinus'); ?> </label>
            <select class="widefat categories-chosen" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple">
                <?php foreach($categories as $item){ ?>
                    <option <?php if (in_array($item->term_id, $category)){ echo 'selected="selected"';} ?> value="<?php echo $item->term_id ?>"><?php echo $item->name; ?></option>
                <?php } ?>
            </select>
        </div>

        <p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php esc_html_e('Order by:', 'delphinus'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option <?php selected( $orderby, 'name' ); ?> value="name"><?php esc_html_e('Name','delphinus'); ?></option>
                <option <?php selected( $orderby, 'id' ); ?> value="id"><?php esc_html_e('ID','delphinus'); ?></option>
                <option <?php selected( $orderby, 'date' ); ?> value="date"><?php esc_html_e('Date','delphinus'); ?></option>
                <option <?php selected( $orderby, 'author' ); ?> value="author"><?php esc_html_e('Author','delphinus'); ?></option>
                <option <?php selected( $orderby, 'modified' ); ?> value="modified"><?php esc_html_e('Modified','delphinus'); ?></option>
                <option <?php selected( $orderby, 'rand' ); ?> value="rand"><?php esc_html_e('Rand','delphinus'); ?></option>
                <option <?php selected( $orderby, 'comment_count' ); ?> value="comment_count"><?php esc_html_e('Comment count','delphinus'); ?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e('Order:','delphinus'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option <?php selected( $order, 'DESC' ); ?> value="DESC"><?php esc_html_e('Desc','delphinus'); ?></option>
                <option <?php selected( $order, 'ASC' ); ?> value="ASC"><?php esc_html_e('ASC','delphinus'); ?></option>
            </select>
        </p>

        <script type="text/javascript">
            (function($){
                $('document').ready(function() {
                    $('.categories-chosen').chosen();
                });
            })(jQuery);
        </script>

    <?php
    }
}




/**
 * Register KT_Posts_Carousel widget
 *
 *
 */

register_widget('Widget_KT_Posts_Carousel');