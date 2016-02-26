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
                            <li class="active">Checkout</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>Checkout</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">
        <div class="page-section">
            <div class="container">
                <div class="woocommerce">
                    <form class="checkout">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="woocommerce-billing-fields box">
                                    <h5 class="title-checkout">Billing Address</h5>
                                    <div class="checkout-wrap">
                                        <div class="form-group">
                                            <label>Country <abbr title="required" class="required">*</abbr></label>
                                            <select class="selector">
                                                <option value="">Select a Country</option>
                                                <option value="US">United States</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Frist Name <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input class="input-bg full-width" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Address <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" placeholder="Street Address" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <input class="input-bg" placeholder="Appartment, unit, etc. (optional)" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Town / City <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" placeholder="Town / City" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>State / County</label>
                                            <input class="input-bg" placeholder="State / County" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Postcode <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" placeholder="Postcode / Zip" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Phone <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <div>
                                                <label><input type="checkbox" />Create an account?</label>
                                            </div>
                                            <p>Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                                            <label>Account password <abbr title="required" class="required">*</abbr></label>
                                            <input class="input-bg" type="password" />
                                        </div>
                                        <div class="woocommerce-shipping-fields box">
                                            <label>
                                                <input type="checkbox" checked>Ship to a different address?
                                            </label>
                                            <label>Order Notes</label>
                                            <div class="form-group">
                                                <textarea class="input-bg"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <h5 class="title-checkout">Promotional Code</h5>
                                <div class="checkout-wrap">
                                    <div class="coupon_wrap">
                                        <p>Enter your coupon code if you have one</p>
                                        <div class="coupon-form">
                                            <input type="text" class="input-bg" placeholder="Coupon Code" />
                                            <input type="submit" class="submit btn btn-medium" value="apply Coupon" />
                                        </div>
                                    </div>
                                </div>
                                <h5 class="title-order">Your order</h5>
                                <div class="checkout-wrap">
                                    <div id="order_review">
                                        <table class="shop_table box">
                                            <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <td class="product-total text-right">TOTAL</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="cart_item">
                                                <th class="product-name">
                                                    Toros Armchair <span class="product-quantity">× 1</span>
                                                </th>
                                                <td class="product-total text-right">
                                                    <span class="amount">$1000.00</span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item">
                                                <th class="product-name">
                                                    Koriander 3 Seater Sofa<span class="product-quantity">× 1</span>
                                                </th>
                                                <td class="product-total text-right">
                                                    <span class="amount">$1500.00</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td class="text-right"><span class="amount">$2500.00</span></td>
                                            </tr>
                                            <tr class="shipping">
                                                <th>Shipping and Handling</th>
                                                <td class="text-right">
                                                    Free Shipping
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td class="text-right"><span class="amount">$2500.00</span></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <div id="payment">
                                            <ul class="payment_methods">
                                                <li class="payment_method_bacs">
                                                    <label class="radio">
                                                        <input id="payment_method_bacs" class="input-radio" name="payment_method" value="bacs" checked="checked" data-order_button_text="" type="radio">
                                                        Direct Bank Transfer
                                                    </label>
                                                    <div class="payment_box payment_method_bacs" style="display: block"><p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                                    </div>
                                                </li>
                                                <li class="payment_method_cheque">
                                                    <label class="radio">
                                                        <input id="payment_method_cheque" class="input-radio" name="payment_method" value="cheque" data-order_button_text="" type="radio">
                                                        Cheque Payment
                                                    </label>
                                                    <div class="payment_box payment_method_cheque"><p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                                    </div>
                                                </li>
                                                <li class="payment_method_paypal">
                                                    <label class="radio">
                                                        <input id="payment_method_paypal" class="input-radio" name="payment_method" value="paypal" data-order_button_text="Proceed to PayPal" type="radio">
                                                        PayPal <img src="http://demo.qodeinteractive.com/bridge/wp-content/plugins/woocommerce/assets/images/icons/paypal.png" alt="PayPal">
                                                    </label>
                                                    <div class="payment_box payment_method_paypal"><p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="form-row place-order">
                                                <noscript>Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.<br/>
                                                    <button type="submit" class="btn btn-medium style1">Update Totals</button>
                                                </noscript>
                                                <button id="place_order" class="btn btn-dark-b">Place Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- #main -->
<?php

include_once('templates/footers/footer3.php');
include_once('templates/footers/foot.php');


