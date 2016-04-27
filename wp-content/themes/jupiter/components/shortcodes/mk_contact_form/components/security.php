<?php

/*
** Stores the email address into database
*/
mk_update_contact_form_email(get_the_ID(), $view_params['id'], $view_params['email']);


wp_nonce_field('mk-contact-form-security', 'security');

echo mk_contact_form_hidden_values($view_params['id'], get_the_ID());