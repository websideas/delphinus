<ul id="main-nav-socials">
    <?php

    $social = kt_option('footer_socials');

    $social = 'facebook,twitter,instagram,linkedin';

    $socials_arr = array(
        'facebook' => array('title' => esc_html__('Facebook', 'adroit'), 'icon' => 'fa fa-facebook', 'link' => '%s'),
        'twitter' => array('title' => esc_html__('Twitter', 'adroit'), 'icon' => 'fa fa-twitter', 'link' => 'http://www.twitter.com/%s'),
        'dribbble' => array('title' => esc_html__('Dribbble', 'adroit'), 'icon' => 'fa fa-dribbble', 'link' => 'http://www.dribbble.com/%s'),
        'vimeo' => array('title' => esc_html__('Vimeo', 'adroit'), 'icon' => 'fa fa-vimeo-square', 'link' => 'http://www.vimeo.com/%s'),
        'tumblr' => array('title' => esc_html__('Tumblr', 'adroit'), 'icon' => 'fa fa-tumblr', 'link' => 'http://%s.tumblr.com/'),
        'skype' => array('title' => esc_html__('Skype', 'adroit'), 'icon' => 'fa fa-skype', 'link' => 'skype:%s'),
        'linkedin' => array('title' => esc_html__('LinkedIn', 'adroit'), 'icon' => 'fa fa-linkedin', 'link' => '%s'),
        'googleplus' => array('title' => esc_html__('Google Plus', 'adroit'), 'icon' => 'fa fa-google-plus', 'link' => '%s'),
        'youtube' => array('title' => esc_html__('Youtube', 'adroit'), 'icon' => 'fa fa-youtube', 'link' => 'http://www.youtube.com/user/%s'),
        'pinterest' => array('title' => esc_html__('Pinterest', 'adroit'), 'icon' => 'fa fa-pinterest', 'link' => 'http://www.pinterest.com/%s'),
        'instagram' => array('title' => esc_html__('Instagram', 'adroit'), 'icon' => 'fa fa-instagram', 'link' => 'http://instagram.com/%s'),
    );

    foreach($socials_arr as $k => &$v){
        $val = kt_option($k);
        $v['val'] = ($val) ? $val : '';
    }
    $social_icons = '';
    if($social){
        $social_type = explode(',', $social);
        foreach ($social_type as $id) {
            $val = $socials_arr[$id];
            $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
            $social_icons .= '<li><a class="'.esc_attr($id).'" title="'.esc_attr($val['title']).'" href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>';
        }
    }else{
        foreach($socials_arr as $key => $val){
            $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
            $social_icons .= '<li><a class="'.esc_attr($key).'" title="'.esc_attr($val['title']).'" href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>';
        }
    }
    echo $social_icons;

    ?>
</ul><!-- #main-nav-socials -->