<?php
vc_map(array(
    "name" => __("Testimonials", "mk_framework") ,
    "base" => "mk_testimonials",
    'icon' => 'icon-mk-testimonial-slideshow vc_mk_element-icon',
    "category" => __('Slideshows', 'mk_framework') ,
    'description' => __('Shows Testimonials in multiple styles.', 'mk_framework') ,
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", "mk_framework") ,
            "param_name" => "title",
            "value" => "",
            "description" => __("", "mk_framework")
        ) ,
        array(
            "heading" => __("Style", 'mk_framework') ,
            "description" => __("", 'mk_framework') ,
            "param_name" => "style",
            "value" => array(
                __("Avant garde", 'mk_framework') => "avantgarde",
                __("Boxed", 'mk_framework') => "boxed",
                __("Modern", 'mk_framework') => "modern",
                __("Simple Centered", 'mk_framework') => "simple"
            ) ,
            "type" => "dropdown"
        ) ,
        array(
            "heading" => __("Show as?", 'mk_framework') ,
            "description" => __("", 'mk_framework') ,
            "param_name" => "show_as",
            "value" => array(
                __("Slideshow", 'mk_framework') => "slideshow",
                __("Column Based", 'mk_framework') => "column"
            ) ,
            "type" => "dropdown"
        ) ,
        array(
            "type" => "range",
            "heading" => __("How many Columns", "mk_framework") ,
            "param_name" => "column",
            "value" => "3",
            "min" => "1",
            "max" => "4",
            "step" => "1",
            "unit" => 'columns',
            "description" => __("If Column based is selected from the option above, you will need to set in how many columns, testimonials will be showed up.", "mk_framework") ,
            "dependency" => array(
                'element' => "show_as",
                'value' => array(
                    'column'
                )
            )
        ) ,
        array(
            "type" => "dropdown",
            "heading" => __("Skin", "mk_framework") ,
            "param_name" => "skin",
            "value" => array(
                __('Dark', "mk_framework") => "dark",
                __('Light', "mk_framework") => "light"
            ) ,
            "description" => __("This option is only for 'Simple Centered' style and you can use it when you need to place this shortcode inside a page section with dark background.", "mk_framework") ,
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'simple',
                    'avantgarde'
                )
            )
        ) ,
        array(
            "type" => "range",
            "heading" => __("Count", "mk_framework") ,
            "param_name" => "count",
            "value" => "10",
            "min" => "-1",
            "max" => "50",
            "step" => "1",
            "unit" => 'testimonial',
            "description" => __("How many testimonial you would like to show? (-1 means unlimited)", "mk_framework")
        ) ,
        array(
            "type" => "multiselect",
            "heading" => __("Select specific Testimonials", "mk_framework") ,
            "param_name" => "testimonials",
            "value" => '',
            "options" => mk_get_post_enteries('testimonial', 40),
            "description" => __("", "mk_framework")
        ) ,
        array(
            "type" => "textfield",
            "heading" => __("Select Specific Categories.", "mk_framework"),
            "param_name" => "categories",
            "value" => '',
            "description" => __("You will need to go to Wordpress Dashboard => Testimonials => Testimonials Categories. In the right hand find Slug column. you will need to add testimonials category slugs in this option. add comma to separate them.", "mk_framework")
        ),
        array(
            "heading" => __("Order", 'mk_framework') ,
            "description" => __("Designates the ascending or descending order of the 'orderby' parameter.", 'mk_framework') ,
            "param_name" => "order",
            "value" => array(
                __("ASC (ascending order)", 'mk_framework') => "ASC",
                __("DESC (descending order)", 'mk_framework') => "DESC"
            ) ,
            "type" => "dropdown"
        ) ,
        array(
            "heading" => __("Orderby", 'mk_framework') ,
            "description" => __("Sort retrieved client items by parameter.", 'mk_framework') ,
            "param_name" => "orderby",
            "value" => $mk_orderby,
            "type" => "dropdown"
        ) ,
        array(
            "type" => "range",
            "heading" => __("Animation Speed", "mk_framework") ,
            "param_name" => "animation_speed",
            "value" => "700",
            "min" => "100",
            "max" => "3000",
            "step" => "1",
            "unit" => 'ms',
            "description" => __("", "mk_framework") ,
            "dependency" => array(
                'element' => "show_as",
                'value' => array(
                    'slideshow'
                )
            )
        ) ,
        array(
            "type" => "range",
            "heading" => __("Slideshow Speed", "mk_framework") ,
            "param_name" => "slideshow_speed",
            "value" => "7000",
            "min" => "1000",
            "max" => "20000",
            "step" => "1",
            "unit" => 'ms',
            "description" => __("", "mk_framework") ,
            "dependency" => array(
                'element' => "show_as",
                'value' => array(
                    'slideshow'
                )
            )
        ) ,
        $add_css_animations,
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "mk_framework") ,
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework")
        )
    )
));
