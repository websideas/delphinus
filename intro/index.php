<!DOCTYPE HTML>
<html>
<head>

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>Delphinus - Just another WordPress site</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>

    <link href="http://fonts.googleapis.com/css?family=Roboto+Slab%3A700" rel="stylesheet" property="stylesheet" type="text/css" media="all" />
    <link href="http://fonts.googleapis.com/css?family=Karla%3A400" rel="stylesheet" property="stylesheet" type="text/css" media="all" />


    <link rel='stylesheet' href='http://delphinus.kitethemes.com/wp-content/plugins/revslider/public/assets/css/settings.css?ver=5.2.5.2' type='text/css' media='all' />
    <link rel='stylesheet' href='http://delphinus.kitethemes.com/wp-content/themes/delphinus/assets/css/plugins.css?ver=4.5.2' type='text/css' media='all' />
    <link rel='stylesheet' href='http://delphinus.kitethemes.com/wp-content/themes/delphinus/assets/css/style.css?ver=4.5.2' type='text/css' media='all' />
    <link rel='stylesheet' href='http://delphinus.kitethemes.com/wp-content/themes/delphinus/assets/css/queries.css?ver=4.5.2' type='text/css' media='all' />

    <!-- Main Style -->
    <link rel="stylesheet" href="assets/css/style.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script type='text/javascript' src='http://delphinus.kitethemes.com/wp-includes/js/jquery/jquery.js?ver=1.12.3'></script>
    <script type='text/javascript' src='http://delphinus.kitethemes.com/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.tools.min.js?ver=5.2.5.2'></script>
    <script type='text/javascript' src='http://delphinus.kitethemes.com/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.revolution.min.js?ver=5.2.5.2'></script>

</head>
<body>

<div id="search-fullwidth" class="mfp-hide mfp-with-anim">
    <form role="search" method="get" class="woocommerce-product-search searchform" action="http://delphinus.kitethemes.com/">
        <label class="screen-reader-text">Search</label>
        <input type="text" class="search-field" placeholder="Search Products&hellip;" value="" name="s" title="Search for:" />
        <button class="submit">
            <i class="fa fa-search"></i>
            <span>Search</span>
        </button>
        <input type="hidden" name="post_type" value="product" />
    </form>
</div>

<div id="page_outter">
    <div id="page">

        <div class="header-container header-layout1  header-dark">

            <?php include_once('header-mobile.php'); ?>
            <?php include_once('mobile.php'); ?>
            <?php include_once('menu.php'); ?>
            <?php include_once('slider.php'); ?>

        </div>
        <?php include_once('content.php'); ?>

    </div><!-- #page -->
</div>

<div id="back-to-top"><i class="fa fa-angle-up"></i></div>

<!-- JS -->
<script type='text/javascript' src='http://delphinus.kitethemes.com/wp-content/themes/delphinus/assets/js/plugins.js'></script>
<script type='text/javascript' src='http://delphinus.kitethemes.com/wp-content/themes/delphinus/assets/js/functions.js'></script>

</body>
</html>