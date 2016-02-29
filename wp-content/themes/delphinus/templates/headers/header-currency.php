<?php

if(class_exists('WOOCS') && kt_is_wc()){


    global $WOOCS;
    $currencies=$WOOCS->get_currencies();

    $currency_html = '';
    $currency_active = '';
    foreach($currencies as $key => $currency){

        if($WOOCS->current_currency == $key){
            $selected = 'active';
            $currency_active = $key;
        }else{
            $selected = '';
        }

        $currency_html .= sprintf(
            '<li class="%s"><a href="#" data-currency="%s" title="%s"><span></span>%s</a>',
            $selected,
            esc_attr($currency['name']),
            esc_attr($currency['description']),
            $currency['name']
        );
    }


    printf(
        '<li class="currency-switcher"><a href="#">%s<ul class="navigation-submenu currency-switcher-content">%s</ul></a></li>',
        $currency_active,
        $currency_html
    );

}