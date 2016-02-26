<?php
    global $shadow;
    if(empty($shadow)){
        $shadow = 'header-shadow';
    }
?>

<!-- header-full-center -->
<header id="header" class="<?php echo $shadow; ?> header-full-center">
    <?php include_once('templates/top-bar.php'); ?>
    <div class="navbar-container sticky-header">
        <div class="navbar-container-inner clearfix">
            <div class="branding">
                <h1 class="logo">
                    <a href="index.php"><img src="assets/images/logo.png" title="Delphinus" alt="Delphinus"/></a>
                </h1>
            </div><!-- .branding -->
            <div class="mobile-tool">
                <a id="hamburger-icon" href="#" title="Menu">
                    <span class="hamburger-icon-inner">
                        <span class="line line-1"></span>
                        <span class="line line-2"></span>
                        <span class="line line-3"></span>
                    </span>
                </a>
                <a href="woocommerce-cart.php" class="mobile-tool-cart">
                    <i class="icon-Shopping-Cart"></i>
                    <span>2</span>
                </a>
            </div>
            <?php include_once('templates/nav.php'); ?>
        </div>
    </div><!-- .navbar-container -->
    <?php include_once('templates/nav-mobile.php'); ?>
</header><!-- #header -->