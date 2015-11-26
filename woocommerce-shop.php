<?php

global $shadow;
$shadow = ' ';

include_once('templates/headers/head.php');
include_once('templates/headers/header2.php');

?>


    <div class="page-section bg-gray small-section">
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">All Products</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>All products</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">
        <div class="page-section">
            <div class="container">

                <div class="row">
                    <div class="col-md-9 col-sm-12 col-xs-12 pull-right">

                        <div class="products-tools clearfix">
                            <form class="products-sortby" method="get" action="#">
                                <div class="select-icon">
                                    <select name="showby">
                                        <option value="15">Show by : &nbsp; 15</option>
                                        <option value="30">Show by : &nbsp; 30</option>
                                        <option value="45">Show by : &nbsp; 45</option>
                                        <option value="-1">Show by : &nbsp; All</option>
                                    </select>
                                </div>
                                <div class="select-icon">
                                    <select name="shortby">
                                        <option value="selling">Sort by : &nbsp; Best selling</option>
                                        <option value="popularity">Sort by : &nbsp; Popularity</option>
                                        <option value="rating">Sort by : &nbsp; Average rating</option>
                                        <option value="date">Sort by : &nbsp; Newness</option>
                                    </select>
                                </div>
                            </form>
                            <div class="result-count">Items 1 - 15 of 28 total</div>
                            <ul class="grid-list">
                                <li><a class="active" href="#" data-layout="grid" data-remove="lists" title="Grid view"><i class="fa fa-th"></i></a></li>
                                <li><a href="#" data-layout="lists" data-remove="grid" title="List view"><i class="fa fa-bars"></i></a></li>
                            </ul>

                        </div>

                        <div class="row multi-columns-row">
                            <div class="products">
                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-1.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-2.jpg" alt=""/>
                                        </a>

                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-2.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-3.jpg" alt=""/>
                                        </a>

                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-3.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-4.jpg" alt=""/>
                                        </a>
                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-4.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-5.jpg" alt=""/>
                                        </a>
                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-5.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-6.jpg" alt=""/>
                                        </a>
                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-6.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-7.jpg" alt=""/>
                                        </a>
                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-7.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-8.jpg" alt=""/>
                                        </a>
                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product-content">
                                        <a href="woocommerce-product-detailed1.php" class="product-thumbnail">
                                            <img class="first-img" src="assets/images/product/product-8.jpg" alt=""/>
                                            <img class="second-img" src="assets/images/product/product-9.jpg" alt=""/>
                                        </a>
                                        <div class="product-over-tool">
                                            <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                            <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            <a href="#" class="quickview" data-toggle="tooltip"  data-placement="top" title="Quick view"><i class="fa fa-search"></i></a>
                                        </div>
                                        <div class="product-over-add">
                                            <a href="#" class="btn btn-addtocart">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product-attribute">
                                        <h3 class="product-title">
                                            <a href="woocommerce-product-detailed1.php">JWDA Concrete Lamp</a>
                                        </h3>
                                        <div class="product-price">$340.00</div>
                                        <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam cursus mi luctus fringilla pretium. Duis est justo, pellentesque vitae imperdiet pharetra, varius ut mauris. Cras mauris magna, </div>
                                        <div class="produt-tool-list clearfix">
                                            <div class="quantity">
                                                <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                            </div>
                                            <div class="product-over-add">
                                                <a href="#" class="btn btn-addtocart-b">add to cart</a>
                                            </div>
                                            <div class="product-over-tool">
                                                <a href="#" class="add_to_wishlist" data-toggle="tooltip"  data-placement="top" title="Add to wishlist"><i class="fa fa-heart"></i></a>
                                                <a href="#" class="add_to_compare" data-toggle="tooltip"  data-placement="top" title="Add to compare"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <nav class="navigation pagination">
                            <div class="nav-links">
                                <a href="#" class="prev page-numbers">
                                    <span class="screen-reader-text">Prev</span>
                                    <i class="icon-Left-3"></i>
                                </a>
                                <span class="page-numbers current">1</span>
                                <a href="#" class="page-numbers">2</a>
                                <span class="page-numbers dots">…</span>
                                <a href="#" class="page-numbers">4</a>
                                <a href="#" class="next page-numbers">
                                    <span class="screen-reader-text">Next</span>
                                    <i class="icon-Right-3"></i>
                                </a>
                            </div>
                        </nav>


                    </div>


                    <div class="col-md-3 col-sm-12 col-xs-12 side-bar">

                        <div class="widget-container widget_product_categories">
                            <h3 class="widget-title">Categories</h3>
                            <ul>
                                <li><a href="#">Chair</a></li>
                                <li><a href="#">Table</a></li>
                                <li><a href="#">Lamp</a></li>
                                <li><a href="#">Watch</a></li>
                                <li><a href="#">Clock</a></li>
                            </ul>
                        </div>

                        <div class="widget-container widget_product_categories">
                            <h3 class="widget-title">Color</h3>
                            <ul>
                                <li><a href="#">Black <span class="count">(5)</span></a></li>
                                <li><a href="#">White <span class="count">(2)</span></a></li>
                                <li><a href="#">Brown <span class="count">(3)</span></a></li>
                                <li><a href="#">Blue <span class="count">(7)</span></a></li>
                                <li><a href="#">Red <span class="count">(15)</span></a></li>
                            </ul>
                        </div>

                        <div class="widget-container widget_product_categories">
                            <h3 class="widget-title">Brands</h3>
                            <ul>
                                <li><a href="#">Aecraft <span class="count">(25)</span></a></li>
                                <li><a href="#">Artek <span class="count">(5)</span></a></li>
                                <li><a href="#">Bower <span class="count">(6)</span></a></li>
                                <li><a href="#">Culinarium <span class="count">(8)</span></a></li>
                                <li><a href="#">Desu <span class="count">(18)</span></a></li>
                            </ul>
                        </div>

                        <div class="widget-container widget_price_filter">
                            <h3 class="widget-title">Price</h3>
                            <form method="get" action="#">
                                <div class="price_slider_wrapper">
                                    <div class="price_slider"></div>
                                    <div class="price_label"><span class="from"></span> - <span class="to"></span></div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>



    </div><!-- #main -->



<?php

include_once('templates/footers/footer3.php');
include_once('templates/footers/foot.php');


