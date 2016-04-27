<?php
	
	/* Visual Composer: Page templates
	================================================== */
	
	function nm_vc_templates( $default_templates ) {
		// Default templates to keep (names)
		$default_keep = array( 
			'About with features',
			'About with left gallery',
			'Centre description',
			'Centre description with image',
			'Description Page',
			'Description with gallery',
			'Description with headings',
			'Description with thumbnails',
			'FAQ section',
			'Feature List',
			'Intro with features',
			'Landing Page',
			'Service List',
			'Three image description',
			'Two column list'
		);
		// Remove default templates not found in $default_keep array
		foreach ( $default_templates as $i => $template ) {
			if ( ! in_array( $template['name'], $default_keep ) ) {
				unset( $default_templates[$i] );
			}
		}
		
		
		// New templates
		$new_templates = array(
			'nm_about' => array(
				'name' 			=> __( 'About', 'nm-framework' ),
				'weight' 		=> 0, // Template list position
				'image_path' 	=> NM_URI . '/assets/img/visual-composer/templates/about.png', // Thumbnail dimensions: 114x154px
				'custom_class'	=> '', // CSS class name
				'content' 		=> '[vc_row type="boxed" max_width=""][vc_column width="5/6" offset="vc_col-sm-offset-1"][vc_empty_space height="47px"][vc_column_text css_animation=""]<h2>Our story so far.</h2>[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" max_width=""][vc_column width="1/1"][vc_empty_space height="43px"][nm_banner layout="full" title_size="small" title_color="#181818" subtitle_color="#888888" link_type="banner_link" text_position="h_center-v_center" text_alignment="align_left" image_type="css" center_content="" height="410" background_color="#eeeeee"][vc_empty_space height="47px"][/vc_column][/vc_row][vc_row type="boxed" max_width=""][vc_column width="1/4" offset="vc_col-sm-offset-1"][vc_column_text css_animation=""]<h4>The Brand</h4>[/vc_column_text][vc_empty_space height="17px"][/vc_column][vc_column width="7/12"][vc_column_text css_animation=""]<p>Messenger bag raw denim health goth pour-over, twee Neutra Vice ethical bespoke. Irony hashtag mixtape kogi blog you probably haven\'t heard of them, fashion axe readymade scenester flexitarian. Ugh bespoke actually vinyl photo booth tattooed paleo Pinterest Schlitz. Cronut hella selfies, flexitarian sriracha keffiyeh Intelligentsia biodiesel.</p><p>Ethical sustainable gastropub chillwave. Gentrify semiotics cold-pressed, narwhal hashtag cardigan artisan swag kale chips raw denim wolf tilde. High Life brunch stumptown salvia, Godard readymade scenester flexitarian.</p>[/vc_column_text][/vc_column][/vc_row][vc_row type="full-nopad" max_width=""][vc_column width="1/1"][vc_empty_space height="40"][/vc_column][/vc_row][vc_row type="boxed" max_width=""][vc_column width="1/4" offset="vc_col-sm-offset-1"][vc_column_text css_animation=""]<h4>Contact Us</h4>[/vc_column_text][vc_empty_space height="17px"][/vc_column][vc_column width="7/12"][vc_column_text css_animation=""]<p>Telephone: 703.172.3412<br><a href="#">hello@yoursite.com</a></p><p>Van Spartan #73, 1081 Amsterdam, Netherlands<br>Monday to Friday: 10am to 7pm</p>[/vc_column_text][/vc_column][/vc_row][vc_row type="full-nopad" max_width=""][vc_column width="1/1"][vc_empty_space height="46"][/vc_column][/vc_row][vc_row type="boxed" max_width="" css=".vc_custom_1432674883870{padding-bottom: 39px !important;}"][vc_column width="1/4" offset="vc_col-sm-offset-1"][vc_column_text css_animation=""]<h4>Our Team</h4>[/vc_column_text][vc_empty_space height="23px"][/vc_column][vc_column width="7/12"][nm_team columns="3" image_style="default"][/vc_column][/vc_row]'
			),
			
			'nm_contact' => array(
				'name' 			=> __( 'Contact', 'nm-framework' ),
				'weight' 		=> 1,
				'image_path' 	=> NM_URI . '/assets/img/visual-composer/templates/contact.png',
				'custom_class'	=> '',
				'content' 		=> '[vc_row][vc_column width="1/1" offset="vc_col-md-offset-1 vc_col-md-10" css=".vc_custom_1430761134394{padding-top: 47px !important;}"][vc_column_text]<h2>We\'d love to hear from you.</h2>[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1" css=".vc_custom_1430758896570{padding-top: 44px !important;}"][nm_gmap address="Leeuwarden, Netherlands" map_type="roadmap_custom" map_style="countries" zoom="5" zoom_controls="1" scroll_zoom="" marker_icon="1057" height="500"][/vc_column][/vc_row][vc_row type="full" css=".vc_custom_1430762920072{padding-top: 66px !important;padding-bottom: 23px !important;}"][vc_column width="1/3" offset="vc_col-md-offset-1 vc_col-md-3" css=".vc_custom_1430761204074{margin-bottom: 42px !important;}"][nm_feature icon_type="icon" icon="pe-7s-paper-plane" icon_style="simple" image_style="default" layout="icon_left" bottom_spacing="none" title="Get in Touch" icon_background_color="#eeeeee" icon_color="#282828"]<p>Telephone: 703.172.3412<br>Fax: 703.172.2341</p><p><a href="#">hello@yoursite.com</a></p>[/nm_feature][/vc_column][vc_column width="1/3" css=".vc_custom_1430761276549{margin-bottom: 42px !important;}" offset="vc_col-md-4"][nm_feature icon_type="icon" icon="pe-7s-map-marker" icon_style="simple" image_style="default" layout="icon_left" bottom_spacing="none" title="Visit Us" icon_background_color="#eeeeee" icon_color="#282828"]<p>Van Spartan #73, 1081 Amsterdam, Netherlands<br>Monday to Friday: 10am to 7pm</p><p><a href="#">Get Directions</a>[/nm_feature][/vc_column][vc_column width="1/3" css=".vc_custom_1430761245107{margin-bottom: 42px !important;}" offset="vc_col-md-3"][nm_feature icon_type="icon" icon="pe-7s-portfolio" icon_style="simple" image_style="default" layout="icon_left" bottom_spacing="none" title="Work with Us?" icon_background_color="#eeeeee" icon_color="#282828"]<p>Etsy mustache selfies Brooklyn letterpress artisan swag.</p><p><a href="#">apply@yoursite.com</a></p>[/nm_feature][/vc_column][/vc_row]'
			),
			
			'nm_faq' => array(
				'name' 			=> __( 'FAQ', 'nm-framework' ),
				'weight' 		=> 2,
				'image_path' 	=> NM_URI . '/assets/img/visual-composer/templates/faq.png',
				'custom_class'	=> '',
				'content' 		=> '[vc_row type="boxed" css=".vc_custom_1432752631369{padding-top: 68px !important;}"][vc_column width="1/4"][vc_column_text el_class="nm-highlight-text"]<h4>Shopping</h4>[/vc_column_text][vc_empty_space height="30px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-4"][vc_column_text css_animation=""]<h6>What Shipping Methods Are Available?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-5"][vc_column_text css_animation=""]Ex Portland Pitchfork irure mustache. Neutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" css=".vc_custom_1432727850842{padding-top: 40px !important;}"][vc_column width="3/4" offset="vc_col-lg-4 vc_col-sm-offset-3"][vc_column_text]<h6>Do You Ship Internationally?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-offset-0 vc_col-lg-5 vc_col-sm-offset-3"][vc_column_text]Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" css=".vc_custom_1432727859836{padding-top: 40px !important;}"][vc_column width="3/4" offset="vc_col-lg-4 vc_col-sm-offset-3"][vc_column_text]<h6>How Long Will It Take To Get My Package?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-offset-0 vc_col-lg-5 vc_col-sm-offset-3"][vc_column_text]Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.[/vc_column_text][/vc_column][/vc_row][vc_row type="full-nopad" css=".vc_custom_1432728062229{padding-top: 46px !important;}"][vc_column width="1/1"][vc_separator title_size="large" title_align="separator_align_center"][/vc_column][/vc_row][vc_row type="boxed" css=".vc_custom_1432728051583{padding-top: 49px !important;}"][vc_column width="1/4"][vc_column_text el_class="nm-highlight-text"]<h4>Payment</h4>[/vc_column_text][vc_empty_space height="30px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-4"][vc_column_text]<h6>What Payment Methods Are Accepted?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-5"][vc_column_text]Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" max_width="" css=".vc_custom_1432727850842{padding-top: 40px !important;}" el_id=""][vc_column width="3/4" offset="vc_col-lg-4 vc_col-sm-offset-3"][vc_column_text]<h6>Is Buying On-Line Safe?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-offset-0 vc_col-lg-5 vc_col-sm-offset-3"][vc_column_text]Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.[/vc_column_text][/vc_column][/vc_row][vc_row type="full-nopad" max_width="" css=".vc_custom_1432728062229{padding-top: 46px !important;}" el_id=""][vc_column width="1/1"][vc_separator border_width="" title="" title_size="large" title_align="separator_align_center"][/vc_column][/vc_row][vc_row type="boxed" max_width="" css=".vc_custom_1432728051583{padding-top: 49px !important;}" el_id=""][vc_column width="1/4"][vc_column_text el_class="nm-highlight-text"]<h4>Orders &amp; Returns</h4>[/vc_column_text][vc_empty_space height="30px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-4"][vc_column_text]<h6>How do I place an Order?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-5"][vc_column_text]Keytar cray slow-carb, Godard banh mi salvia pour-over. Slow-carb Odd Future seitan normcore. Master cleanse American Apparel gentrify flexitarian beard slow-carb next level. Raw denim polaroid paleo farm-to-table, put a bird on it lo-fi tattooed Wes Anderson Pinterest letterpress. Fingerstache McSweeney\'s pour-over, letterpress Schlitz photo booth master cleanse bespoke hashtag chillwave gentrify.[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" max_width="" css=".vc_custom_1432727850842{padding-top: 40px !important;}" el_id=""][vc_column width="3/4" offset="vc_col-lg-4 vc_col-sm-offset-3"][vc_column_text]<h6>How Can I Cancel Or Change My Order?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-offset-0 vc_col-lg-5 vc_col-sm-offset-3"][vc_column_text]Plaid letterpress leggings craft beer meh ethical Pinterest. Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth.[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" max_width="" css=".vc_custom_1432727850842{padding-top: 40px !important;}" el_id=""][vc_column width="3/4" offset="vc_col-lg-4 vc_col-sm-offset-3"][vc_column_text]<h6>Do I need an account to place an order?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-offset-0 vc_col-lg-5 vc_col-sm-offset-3"][vc_column_text]Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY. Cray ugh 3 wolf moon fap, fashion axe irony butcher cornhole typewriter chambray VHS banjo street art.[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" max_width="" css=".vc_custom_1432727850842{padding-top: 40px !important;}" el_id=""][vc_column width="3/4" offset="vc_col-lg-4 vc_col-sm-offset-3"][vc_column_text]<h6>How Do I Track My Order?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-offset-0 vc_col-lg-5 vc_col-sm-offset-3"][vc_column_text]Keytar cray slow-carb, Godard banh mi salvia pour-over. Slow-carb @Odd Future seitan normcore. Master cleanse American Apparel gentrify flexitarian beard slow-carb next level.[/vc_column_text][/vc_column][/vc_row][vc_row type="boxed" css=".vc_custom_1432729671370{padding-top: 40px !important;padding-bottom: 74px !important;}"][vc_column width="3/4" offset="vc_col-lg-4 vc_col-sm-offset-3"][vc_column_text]<h6>How Can I Return a Product?</h6>[/vc_column_text][vc_empty_space height="14px"][/vc_column][vc_column width="3/4" offset="vc_col-lg-offset-0 vc_col-lg-5 vc_col-sm-offset-3"][vc_column_text]Kale chips Truffaut Williamsburg, hashtag fixie Pinterest raw denim c hambray drinking vinegar Carles street art Bushwick gastropub. Wolf Tumblr paleo church-key. Plaid food truck Echo Park YOLO bitters hella, direct trade Thundercats leggings quinoa before they sold out. You probably haven\'t heard of them wayfarers authentic umami drinking vinegar Pinterest Cosby sweater, fingerstache fap High Life.[/vc_column_text][/vc_column][/vc_row]'
			)
		);
		
		
		// Merge new and default template arrays (using "array_unshift()" to keep index keys in correct order)
		foreach ( array_reverse( $new_templates ) as $template ) {
			array_unshift( $default_templates, $template );
		}
		
		return $default_templates;
	}
	add_filter( 'vc_load_default_templates', 'nm_vc_templates' );
