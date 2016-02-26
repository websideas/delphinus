<?php

if(kt_is_wpml()) {
    kt_custom_wpml('<li class="language-switcher">', '</li>', esc_html__('Language', 'wingman'));
}