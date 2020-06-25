<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  | example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  | https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  | $route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  | $route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  | $route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples: my-controller/index -> my_controller/index
  |   my-controller/my-method -> my_controller/my_method
 */

/* * ******************* STATIC PAGES ROUTING ********************* */
    $route['404_override'] = '';
    $route['translate_uri_dashes'] = FALSE;
    //$route["selleracc"] = "user/login";

switch ($_SERVER['HTTP_HOST']) {
    
    case 'm.atzcart.localhost':

        $route["robots.txt"] = "sitemap/robots";
        $route["login"] = "m/signin";
        $route['(:any)'] = "m/$1";
        $route['default_controller'] = "m/home";
        $route["signin"] = "m/signin";
        $route["register"] = "m/register";
        $route["register/verify_otp"]="m/register/verify_otp";
        $route["signin/forgot-password"]="m/signin/forgot_password";
        $route["signin/reset-password"]="m/signin/reset_password";
        $route["home"] = "m/home";
        $route["signout"] = "m/signout";
        $route["product"] = "m/product";
        $route["product/productOverview/(:any)"] = "m/product/productOverview/$1";
        $route["product/send_enquiry/(:any)"] = "m/product/send_enquiry/$1";
        $route["product/place_order"] = "m/product/place_order";
        $route["product/product_enquiry"] = "m/product/product_enquiry";
        $route["product/success_enquiry"] = "m/product/success_enquiry";
        $route["product/place_order/(:any)"] = "m/product/place_order/$1";
        $route["product/add_shipping_address"] = "m/product/add_shipping_address";
        $route["product/shipping_form"] = "m/product/shipping_form";
        $route["rfq/rfq_product/(:any)"] = "m/rfq/rfq_product/$1";
        $route["rfq/insertRfq"] = "m/rfq/insertRfq";
        $route["supplier/index/(:any)"] = "m/supplier/index/$1";
        $route["home/productList/(:any)"] = "m/home/productList/$1";
        $route["home/subcategory/(:any)"] = "m/home/subcategory/$1";
        $route["home/topselling"] =         "m/home/topSellingList";
        $route["home/sortProducts"] =     "m/home/sortProducts";
        $route["home/mob_search_product"] = "m/home/mob_search_product";

        /* Start Order Pages Routes */
        $route["product/place_order_product"] = "m/product/place_order_product";
        $route["product/shipping_form"] = "m/product/shipping_form";
        $route["product/edit_shipping_form/(:any)"] = "m/product/edit_shipping_form/$1";
        $route["product/update_shipping_form"]="m/product/update_shipping_form";
        $route["product/addtocart"] = "m/product/addtocart";
        $route["product/start_order/(:any)"] = "m/product/start_order/$1";
        $route["product/atz_messgae"] = "m/product/atz_messgae";
        $route["product/order_success/(:any)"] = "m/product/order_success/$1"; //change Here Passing Order Id
        $route["product/submit_shipping_form"] = "m/product/submit_shipping_form";
        $route["product/ship_order/(:any)"] = "m/product/ship_order/$1";
        $route["home/help_desk/(:any)"]="m/home/help_desk/$1";

        /* Menus Routes */
        $route["home/favourite"]="m/home/favourite";
        $route["home/send_enquiry"]="m/home/send_enquiry";
        $route["home/rfq"]="m/home/rfq";
        $route["home/coupons"]="m/home/coupons";
        $route["home/myorders"]="m/home/myorders";
        $route["signin/change_password"]="m/signin/change_password";
        $route["home/proceed_to_return"]="m/home/proceed_to_return";
        $route["home/return_proceed"]="m/home/return_proceed";
        $route["help"]="m/help/index";

        /* Add Favourite Product */
        $route["product/add_favourite_product"] = "m/product/add_favourite_product";
        $route["product/remove_favourite_product"] =  "m/product/remove_favourite_product";
        $route["home/mycart"]='m/home/mycart';
        $route["product/removeCartProduct"] =  "m/product/removeCartProduct";
        $route["product/startOrderForCartProduct/(:any)"]="m/product/startOrderForCartProduct/$1";
        $route["home/getCartProducts"]="m/home/getCartProducts";
        $route["product/place_order_cart_product"]="m/product/place_order_cart_product";
        $route["product/ship_cart_product/(:any)"] = "m/product/ship_cart_product/$1";

         /* Coupon */
        $route["product/getCoupon"] = "m/product/getCoupon";
        $route["product/coupon_product/(:any)"] = "m/product/coupon_product/$1";
        /* --------------Supplier----------- */
        $route["supplier/(:any)"] = "m/supplier/index/$1";
        $route["supplier/supplier_products/(:any)"] = "m/supplier/supplier_products/$1";
        $route["supplier/supplier_profile/(:any)"] = "m/supplier/supplier_profile/$1";
        $route["supplier/supplier_videos/(:any)"] = "m/supplier/supplier_videos/$1";

    /* --------------terms and condition----------- */
        $route["policy"] = "m/policy";
        $route["policy/cookie"] = "m/policy/cookie";
        $route["policy/term"] = "m/policy/term";

        /* --------------Track Order----------- */
        $route["track_order"] ="m/track_order";
        $route["myorders/trackorder/(:any)"]="m/track_Order/index/$1";
        $route["trackorder/getOrderProductDetails/(:any)"]="m/track_Order/getOrderProductDetails/$1";
        $route["myorders/help_desk/(:any)"]="m/home/help_desk/$1";
        $route["myorders/return_proceed_view/(:any)"]="m/home/return_proceed_view/$1";
        $route["product/delete_shipping_address/(:num)"] = "m/product/delete_shipping_address/$1";

        /* -----------------Order Cancel --------*/
        $route["orders/(:any)"] = "m/orders/index/$1";
        $route["orders/submit_cancel_order"]="m/orders/submit_cancel_order";
        $route["mywallet/withdraw"]="m/mywallet/withdraw";

        /**************** bank *****************/
        $route["bank"] = "m/Bank";
        $route["home/sortProducts"] = "m/home/sortProducts";
        $route["search"] = "search";
        $route["search/results/(:any)/(:num)/(:any)/(:any)"] = "m/search/results/$1/$2/$3/$4";
        $route['404_override'] = 'm/home/notfound';
        break;
		
		
        $route["robots.txt"] = "sitemap/robots";
        $route["login"] = "m/signin";
        $route['(:any)'] = "m/$1";
        $route['default_controller'] = "m/home";
        $route["signin"] = "m/signin";
        $route["register"] = "m/register";
        $route["register/verify_otp"]="m/register/verify_otp";
        $route["signin/forgot-password"]="m/signin/forgot_password";
        $route["signin/reset-password"]="m/signin/reset_password";
        $route["home"] = "m/home";
        $route["signout"] = "m/signout";
        $route["product"] = "m/product";
        $route["product/productOverview/(:any)"] = "m/product/productOverview/$1";
        $route["product/send_enquiry/(:any)"] = "m/product/send_enquiry/$1";
        $route["product/place_order"] = "m/product/place_order";
        $route["product/product_enquiry"] = "m/product/product_enquiry";
        $route["product/success_enquiry"] = "m/product/success_enquiry";
        $route["product/place_order/(:any)"] = "m/product/place_order/$1";
        $route["product/add_shipping_address"] = "m/product/add_shipping_address";
        $route["product/shipping_form"] = "m/product/shipping_form";
        $route["rfq/rfq_product/(:any)"] = "m/rfq/rfq_product/$1";
        $route["rfq/insertRfq"] = "m/rfq/insertRfq";
        $route["supplier/index/(:any)"] = "m/supplier/index/$1";
        $route["home/productList/(:any)"] = "m/home/productList/$1";
        $route["home/subcategory/(:any)"] = "m/home/subcategory/$1";
        $route["home/topselling"] =         "m/home/topSellingList";
        $route["home/sortProducts"] =     "m/home/sortProducts";
        $route["home/mob_search_product"] = "m/home/mob_search_product";

        /* Start Order Pages Routes */
        $route["product/place_order_product"] = "m/product/place_order_product";
        $route["product/shipping_form"] = "m/product/shipping_form";
        $route["product/edit_shipping_form/(:any)"] = "m/product/edit_shipping_form/$1";
        $route["product/update_shipping_form"]="m/product/update_shipping_form";
        $route["product/addtocart"] = "m/product/addtocart";
        $route["product/start_order/(:any)"] = "m/product/start_order/$1";
        $route["product/atz_messgae"] = "m/product/atz_messgae";
        $route["product/order_success/(:any)"] = "m/product/order_success/$1"; //change Here Passing Order Id
        $route["product/submit_shipping_form"] = "m/product/submit_shipping_form";
        $route["product/ship_order/(:any)"] = "m/product/ship_order/$1";
        $route["home/help_desk/(:any)"]="m/home/help_desk/$1";

        /* Menus Routes */
        $route["home/favourite"]="m/home/favourite";
        $route["home/send_enquiry"]="m/home/send_enquiry";
        $route["home/rfq"]="m/home/rfq";
        $route["home/coupons"]="m/home/coupons";
        $route["home/myorders"]="m/home/myorders";
        $route["signin/change_password"]="m/signin/change_password";
        $route["home/proceed_to_return"]="m/home/proceed_to_return";
        $route["home/return_proceed"]="m/home/return_proceed";
        $route["help"]="m/help/index";

        /* Add Favourite Product */
        $route["product/add_favourite_product"] = "m/product/add_favourite_product";
        $route["product/remove_favourite_product"] =  "m/product/remove_favourite_product";
        $route["home/mycart"]='m/home/mycart';
        $route["product/removeCartProduct"] =  "m/product/removeCartProduct";
        $route["product/startOrderForCartProduct/(:any)"]="m/product/startOrderForCartProduct/$1";
        $route["home/getCartProducts"]="m/home/getCartProducts";
        $route["product/place_order_cart_product"]="m/product/place_order_cart_product";
        $route["product/ship_cart_product/(:any)"] = "m/product/ship_cart_product/$1";

         /* Coupon */
        $route["product/getCoupon"] = "m/product/getCoupon";
        $route["product/coupon_product/(:any)"] = "m/product/coupon_product/$1";
        /* --------------Supplier----------- */
        $route["supplier/(:any)"] = "m/supplier/index/$1";
        $route["supplier/supplier_products/(:any)"] = "m/supplier/supplier_products/$1";
        $route["supplier/supplier_profile/(:any)"] = "m/supplier/supplier_profile/$1";
        $route["supplier/supplier_videos/(:any)"] = "m/supplier/supplier_videos/$1";

    /* --------------terms and condition----------- */
        $route["policy"] = "m/policy";
        $route["policy/cookie"] = "m/policy/cookie";
        $route["policy/term"] = "m/policy/term";

        /* --------------Track Order----------- */
        $route["track_order"] ="m/track_order";
        $route["myorders/trackorder/(:any)"]="m/track_Order/index/$1";
        $route["trackorder/getOrderProductDetails/(:any)"]="m/track_Order/getOrderProductDetails/$1";
        $route["myorders/help_desk/(:any)"]="m/home/help_desk/$1";
        $route["myorders/return_proceed_view/(:any)"]="m/home/return_proceed_view/$1";
        $route["product/delete_shipping_address/(:num)"] = "m/product/delete_shipping_address/$1";

        /* -----------------Order Cancel --------*/
        $route["orders/(:any)"] = "m/orders/index/$1";
        $route["orders/submit_cancel_order"]="m/orders/submit_cancel_order";
        $route["mywallet/withdraw"]="m/mywallet/withdraw";

        /**************** bank *****************/
        $route["bank"] = "m/Bank";
        $route["home/sortProducts"] = "m/home/sortProducts";
        $route["search"] = "search";
        $route["search/results/(:any)/(:num)/(:any)/(:any)"] = "m/search/results/$1/$2/$3/$4";
        $route['404_override'] = 'm/home/notfound';
        break;


    case 'seller.atzcart.com':
        $route["default_controller"] = "seller/createaccount";
        break;

    default:
        $route['default_controller'] = 'welcome';
        /******************** SOURCING SOLUTIONS ROUTES********************* */
        $route['top-selected-supplier'] = 'sourcing_solutions';
        $route['suppliers-by-regions'] = 'sourcing_solutions/suppliers_region';
        $route['suppliers-by-regions/(:any)'] = 'sourcing_solutions/regionwise_suppliers/$1';
        $route['submit-rfq'] = 'welcome/add_rfqs';
        $route['submit-rfqs'] = 'welcome/add_rfqs';

        /******************** TRADE SERVICES ROUTES ********************* */
        $route['trade-assurance'] = 'trade_services';
        $route['logistics-service'] = 'trade_services/logistic_service';
        $route['pay-later'] = 'trade_services/pay_Later';
        
        /******************** Affiliate Marketing ********************* */
        $route['affiliate-marketing'] = 'trade_services/affiliateMarketing';
        
        /******************** CUSTOMER SERVICES ROUTES ********************* */
        $route['help-center'] = 'customer_service';
        $route['contact-us'] = 'customer_service/Contact_us';
        $route['for-suppliers'] = 'customer_service/for_supplier';
        $route['for-new-users'] = 'customer_service/new_user';
        $route['submit-a-dispute'] = 'customer_service/submit_dispute';

        $route['policies-rules'] = 'customer_service/policies_rules';
        $route['help-center-description/(:num)'] = 'customer_service/getDesciption/$1';
        $route['help-center-seller-description/(:num)'] = 'customer_service/getDesciptionOfSeller/$1';

        /* ****************** WELCOME ROUTES ********************* */
        $route['all-categories'] = 'welcome/all_categories';
        $route['search-product'] = 'welcome/search_product';
        $route['submit-rfqs'] = 'welcome/add_rfqs';
        $route['supplier-membership'] = 'welcome/becomeseller';

        /******************* HOMEPRODUCT ROUTES ********************* */
        $route['favorite'] = 'home_product/favouriteProduct';
        $route['remove-favorite/(:num)'] = 'home_product/removefavouriteProduct/$1';
        $route['remove-seller/(:num)'] = 'home_product/deletefavoriteseller/$1';

        $route['addToCart'] = 'home_product/add_to_cart';
        $route['getaddedCartProducts'] = 'home_product/get_addedCartProducts';
        $route['getaddefavoriteProducts'] = 'home_product/get_addefavoriteProducts';

        $route['purchaseList'] = 'home_product/getCartProducts';
        $route['removeCartProduct/(:num)'] = 'home_product/removeCart/$1';
        $route['product-catalog/(:any)/(:num)'] = 'home_product/get_products/$1/$2';
        $route['product-details/(:any)/(:num)'] = 'home_product/get_Product_details/$1/$2';
        $route['product-inquiry/(:num)'] = 'home_product/product_inquiry/$1';

        $route["company-details/(:any)"] = "companies/index/$1";
        $route['catalog/(:any)/(:num)'] = 'home_product/get_all_products_categorywise/$1/$2';
        $route['startOrder'] = 'userorder/startOrder';
        $route['startOrderForCartProduct/(:num)'] = 'userorder/startOrderForCartProduct/$1';
        $route['proceedResponseCartProduct'] = 'userorder/proceedResponseCartProduct';
        $route["admin/seller/profile/(:num)"] = "admin/users/user_view/$1";

        $route["filterProduct"] = "home_product/filterProduct";

        $route["forgot-password"] = "login/forgot_password";
        $route["reset-password"] = "login/reset_password";
        $route["change-email"] = "buyer/myaccount/change_email_address";
        $route["change-password"] = "buyer/myaccount/change_password";

        $route["change-security-questions"] = "buyer/myaccount/set_security_questions";
        $route["Security-questions/(:num)"] = "buyer/myaccount/update_security_questions/$1";

        /*************************** Buyer Dashboard ****************/

        $route["buyer-dashboard"] = "buyer/dashboard";
        $route["buyer-orders"] = "buyer/myorders";
        $route["login-security"] = "buyer/login_security";
        $route["buyer-rfqs"] = "buyer/rfqs";
        $route["buyer-addressbook"] = "buyer/addressbook";
        $route["buyer-payment"] = "buyer/payment";
        $route["buyer-wallet"] = "buyer/wallet";
        $route["buyer-reviews"] = "buyer/review";
        $route["buyer-inquiries"] = "buyer/inquiries";
        $route["buyer-coupons"] = "buyer/mycoupons";

        /*********************** Buyers Order *************************/
        $route["order-details/(:num)"] = "buyer/myorders/order_view/$1";
        $route["track-order/(:num)"] = "buyer/myorders/track_order/$1";
        $route["return-order/(:num)"] = "buyer/return_order/index/$1";
        $route["ship-order/(:num)"] = "userorder/ship_order/$1";
        $route["cancel-order"] = "buyer/myorders/cancel_order";
        $route["finalOrderInvoice/(:num)"] = "buyer/myorders/finalOrderInvoice/$1";


        //$route["suppliers-by-region"] = "welcome/suppliers_by_region";
        $route['admin'] = 'admin/login';
        $route["createaccount"] = "seller/createaccount";
        $route["createaccount/verify"] = "seller/createaccount/verify";
        $route["createaccount/companyprofile"] = "seller/createaccount/companyprofile";
        $route["createaccount/taxinfo"] = "seller/createaccount/taxinfo";
        $route['all_categories'] = 'welcome/all_categories';
        $route["sitemap\.xml"] = 'sitemap/index';
        $route['sitemap/sitemap_category\.xml'] = 'sitemap/category';
        $route['sitemap/sitemap_product\.xml'] = 'sitemap/product';
        $route['sitemap/sitemap_common\.xml'] = 'sitemap/allstatic';
        break;
}