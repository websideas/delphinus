<ul class="top-navigation">
    <?php if ( kt_is_wc()){ ?>
        <li>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                <i class="icon_lock_alt"></i>
                <?php esc_html_e('My Account', 'wingman'); ?>
            </a>
        </li>
    <?php } ?>

    <?php
        kt_custom_wpml('<li class="language-switcher">', '</li>', esc_html__('Language', 'wingman'));
    ?>

    <?php if(class_exists('WOOCS') && kt_is_wc()){ ?>
        <li class="currency-switcher">
            <a href="#"><i class="icon_currency"></i><?php esc_html_e('Currency', 'wingman') ?></a>
            <?php
            global $WOOCS;
            $currencies=$WOOCS->get_currencies();
            //print_r($currencies);
            echo '<ul class="currency-switcher-content">';
            foreach($currencies as $key => $currency){
                $selected = ($WOOCS->current_currency == $key) ? 'active' : '';
                printf(
                    '<li class="%s"><a href="#" data-currency="%s" title="%s"><span></span>%s</a>',
                    $selected,
                    esc_attr($currency['name']),
                    esc_attr($currency['description']),
                    $currency['name']
                );
            }
            echo '</ul>';
            ?>
        </li>
    <?php } ?>

</ul>