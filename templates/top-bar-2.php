<div class="topbar">
    <div class="row">
        <div class="topbar-left col-sm-6">
            <ul class="top-navigation">
                <li class="language-switcher">
                    <a href="#">EN</a>
                    <ul class="top-navigation-submenu">
                        <li><a href="#">FR</a></li>
                        <li class="active"><a href="#">EN</a></li>
                        <li><a href="#">DE</a></li>
                    </ul>
                </li><!-- .language-switcher -->

                <li class="currency-switcher">
                    <a href="#">USD</a>
                    <ul class="top-navigation-submenu">
                        <li><a href="#">EUR</a></li>
                        <li class="active"><a href="#">USD</a></li>
                    </ul>
                </li><!-- .language-switcher -->
                
                <li class="search-action">
                    <a href="#search-fullwidth"><i class="fa fa-search"></i></a>
                </li>
            </ul><!-- .top-navigation -->
        </div><!-- .topbar-left -->


        <div class="topbar-right col-sm-6">
            <ul class="top-navigation">
                <li class="myaccount-item">
                    <a href="#">login</a>
                    <div class="top-navigation-submenu">
                        <h3 class="submenu-heading">Login</h3>
                        <form class="login" method="post">
                            <div class="myaccount-form">
                                <p>
                                    <label for="username">Username or email address</label>
                                    <input type="text" value="" id="username" name="username" class="input-text">
                                </p>
                                <p>
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="input-text">
                                </p>
                                <p>
                                    <input type="submit" value="Login" name="login" class="btn btn-dark-b">
                                    <label class="inline" for="rememberme">
                                        <input type="checkbox" value="forever" id="rememberme" name="rememberme">Remember me
                                    </label>
                                    <a href="#" class="forget-password">Lost your password?</a>
                                </p>
                            </div>
                            <div class="myaccount-create">
                                Not registered? No problem
                                <input type="submit" value="create account" name="create" class="btn btn-gray pull-right">
                            </div>
                        </form>
                    </div>
                </li>
                <li class="wishlist-item">
                    <a href="woocommerce-wishlist.php">
                        wishlist <span>1</span>
                    </a>
                    <div class="top-navigation-submenu">
                        <div class="shopping-bag">
                            <div class="shopping-bag-content">
                                <!--<p class="cart_block_no_products">Your wishlist is empty.</p>--><!-- .cart_block_no_products-->
                                <div class="bag-products">
                                    <div class="bag-product">
                                        <figure>
                                            <a href="#" class="bag-product-img">
                                                <img src="assets/images/product-cart-1.jpg" alt="" class="img-responsive">
                                            </a>
                                        </figure>
                                        <div class="bag-product-details">
                                            <h4 class="bag-product-title"><a href="#">Le grand cartable</a></h4>
                                            <div class="bag-product-price">Price: <span class="amount">$1000.00</span></div>
                                        </div>
                                        <a title="Remove this item" class="remove" href="#"></a>
                                    </div><!-- .bag-product -->
                                </div><!-- .bag-products -->

                                <div class="bag-buttons">
                                    <a class="btn btn-block btn-gray" href="#">View Wishlist</a>
                                </div><!-- .bag-buttons -->

                            </div><!-- .shopping-bag-content -->
                        </div><!-- .shopping-bag -->
                    </div>
                </li>
                <li class="shopping-bag-item">
                    <a href="woocommerce-cart.php">my cart <span>2</span></a>

                    <div class="top-navigation-submenu">
                        <div class="shopping-bag">
                            <!--<p class="cart_block_no_products">Your cart is currently empty.</p>--><!-- .cart_block_no_products-->
                            <div class="bag-products">
                                <div class="bag-product">
                                    <figure>
                                        <a href="#" class="bag-product-img">
                                            <img src="assets/images/product-cart-1.jpg" alt="" class="img-responsive">
                                        </a>
                                    </figure>
                                    <div class="bag-product-details">
                                        <h4 class="bag-product-title"><a href="#">Le grand cartable</a></h4>
                                        <div class="bag-product-price">Price: <span class="amount">$1000.00</span></div>
                                        <div class="bag-product-qty">Quantity: 1</div>
                                    </div>
                                    <a title="Remove this item" class="remove" href="#"></a>
                                </div><!-- .bag-product -->

                                <div class="bag-product">
                                    <figure>
                                        <a href="#" class="bag-product-img">
                                            <img src="assets/images/product-cart-2.jpg" alt="" class="img-responsive">
                                        </a>
                                    </figure>
                                    <div class="bag-product-details">
                                        <h4 class="bag-product-title"><a href="#">Le grand cartable</a></h4>
                                        <div class="bag-product-price">Price: <span class="amount">$1000.00</span></div>
                                        <div class="bag-product-qty">Quantity: 1</div>
                                    </div>
                                    <a title="Remove this item" class="remove" href="#"></a>
                                </div><!-- .bag-product -->


                            </div><!-- .bag-products -->

                            <div class="bag-buttons">
                                <a class="btn-block btn btn-gray" href="woocommerce-cart.php">View Cart</a>
                                <a class="btn-block btn btn-dark-b" href="woocommerce-checkout.php">Checkout</a>
                            </div><!-- .bag-buttons -->

                        </div><!-- .shopping-bag -->
                    </div>

                </li>
            </ul><!-- .top-navigation -->
        </div><!-- .topbar-right -->

    </div>
</div><!-- .topbar -->