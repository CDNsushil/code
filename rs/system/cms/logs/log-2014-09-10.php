<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2014-09-10 06:07:55 --> Page Missing: membership/paypalPayment/3
ERROR - 2014-09-10 06:07:55 --> Page Missing: membership/paypalPayment/3
ERROR - 2014-09-10 10:24:48 --> Query error: Unknown column 'pp.id' in 'order clause' - Invalid query: SELECT `pp`.`merchant_id`, count(pp.affiliate_id) AS countProduct, `pp`.`affiliate_id`, `pp`.`purchase_id`, `ut`.`first_name`, `ut`.`email`, `ut`.`created_on`, `mb`.`banner_name`
FROM `default_purchase_product` as `pp`
LEFT JOIN `default_users` as `ut` ON `ut`.`id` =`pp`.`affiliate_id`
LEFT JOIN `default_merchant_banner` as `mb` ON `mb`.`banner_id` =`pp`.`banner_id`
WHERE `pp`.`merchant_id` =  1
GROUP BY `ut`.`id`
ORDER BY `pp`.`id` DESC
ERROR - 2014-09-10 10:25:15 --> Query error: Unknown column 'pp.id' in 'order clause' - Invalid query: SELECT `pp`.`merchant_id`, count(pp.affiliate_id) AS countProduct, `pp`.`affiliate_id`, `pp`.`purchase_id`, `ut`.`first_name`, `ut`.`email`, `ut`.`created_on`, `mb`.`banner_name`
FROM `default_purchase_product` as `pp`
LEFT JOIN `default_users` as `ut` ON `ut`.`id` =`pp`.`affiliate_id`
LEFT JOIN `default_merchant_banner` as `mb` ON `mb`.`banner_id` =`pp`.`banner_id`
WHERE `pp`.`merchant_id` =  1
GROUP BY `ut`.`id`
ORDER BY `pp`.`id` DESC
ERROR - 2014-09-10 10:25:20 --> Query error: Unknown column 'pp.id' in 'order clause' - Invalid query: SELECT `pp`.`merchant_id`, count(pp.affiliate_id) AS countProduct, `pp`.`affiliate_id`, `pp`.`purchase_id`, `ut`.`first_name`, `ut`.`email`, `ut`.`created_on`, `mb`.`banner_name`
FROM `default_purchase_product` as `pp`
LEFT JOIN `default_users` as `ut` ON `ut`.`id` =`pp`.`affiliate_id`
LEFT JOIN `default_merchant_banner` as `mb` ON `mb`.`banner_id` =`pp`.`banner_id`
WHERE `pp`.`merchant_id` =  1
GROUP BY `ut`.`id`
ORDER BY `pp`.`id` DESC
ERROR - 2014-09-10 10:43:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ut.first_name, `ut`.`email`, `ut`.`created_on`, `mb`.`banner_name`
FROM `default' at line 2 - Invalid query: SELECT `pp`.`merchant_id`, count(pp.affiliate_id) AS countProduct, `pp`.`affiliate_id`, `pp`.`purchase_id`, count(pp.commision) AS totalCommission
		ut.first_name, `ut`.`email`, `ut`.`created_on`, `mb`.`banner_name`
FROM `default_purchase_product` as `pp`
LEFT JOIN `default_users` as `ut` ON `ut`.`id` =`pp`.`affiliate_id`
LEFT JOIN `default_merchant_banner` as `mb` ON `mb`.`banner_id` =`pp`.`banner_id`
WHERE `pp`.`merchant_id` =  1
GROUP BY `ut`.`id`, `pp`.`affiliate_id`
ORDER BY `pp`.`purchase_id` DESC
ERROR - 2014-09-10 10:44:05 --> Query error: Unknown column 'pp.commision' in 'field list' - Invalid query: SELECT `pp`.`merchant_id`, count(pp.affiliate_id) AS countProduct, `pp`.`affiliate_id`, `pp`.`purchase_id`, count(pp.commision) AS totalCommission, `ut`.`first_name`, `ut`.`email`, `ut`.`created_on`, `mb`.`banner_name`
FROM `default_purchase_product` as `pp`
LEFT JOIN `default_users` as `ut` ON `ut`.`id` =`pp`.`affiliate_id`
LEFT JOIN `default_merchant_banner` as `mb` ON `mb`.`banner_id` =`pp`.`banner_id`
WHERE `pp`.`merchant_id` =  1
GROUP BY `ut`.`id`, `pp`.`affiliate_id`
ORDER BY `pp`.`purchase_id` DESC
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$transaction_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 50
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$amount /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 51
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$payment_method /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 53
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$created_at /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 55
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$banner_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 56
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$transaction_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 50
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$amount /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 51
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$payment_method /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 53
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$created_at /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 55
ERROR - 2014-09-10 10:55:18 --> Severity: Notice  --> Undefined property: stdClass::$banner_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 56
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$transaction_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 50
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$amount /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 51
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$payment_method /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 53
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$created_at /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 55
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$banner_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 56
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$transaction_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 50
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$amount /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 51
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$payment_method /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 53
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$created_at /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 55
ERROR - 2014-09-10 10:56:04 --> Severity: Notice  --> Undefined property: stdClass::$banner_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 56
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$transaction_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 50
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$amount /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 51
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$payment_method /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 53
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$created_at /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 55
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$banner_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 56
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$transaction_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 50
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$amount /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 51
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$payment_method /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 53
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$created_at /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 55
ERROR - 2014-09-10 10:56:19 --> Severity: Notice  --> Undefined property: stdClass::$banner_id /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/purchase_view.php 56
ERROR - 2014-09-10 10:56:41 --> Severity: Notice  --> Undefined variable: affiliates /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 32
ERROR - 2014-09-10 10:56:41 --> Severity: Warning  --> Invalid argument supplied for foreach() /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 32
ERROR - 2014-09-10 11:11:46 --> Severity: Notice  --> Undefined variable: affiliates /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 32
ERROR - 2014-09-10 11:11:46 --> Severity: Warning  --> Invalid argument supplied for foreach() /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 32
ERROR - 2014-09-10 11:12:16 --> Severity: Notice  --> Undefined variable: affi /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 38
ERROR - 2014-09-10 11:12:16 --> Severity: Notice  --> Trying to get property of non-object /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 38
ERROR - 2014-09-10 11:12:16 --> Severity: Notice  --> Undefined variable: affi /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 38
ERROR - 2014-09-10 11:12:16 --> Severity: Notice  --> Trying to get property of non-object /var/www/html/referralsystem/php/addons/shared_addons/modules/merchant/views/affiliate_payout.php 38
ERROR - 2014-09-10 11:37:46 --> Severity: Notice  --> Undefined variable: referral /var/www/html/referralsystem/php/system/cms/modules/users/views/profile/edit.php 84
ERROR - 2014-09-10 11:48:53 --> Page Missing: testimonial
ERROR - 2014-09-10 11:51:25 --> Page Missing: testimonial
ERROR - 2014-09-10 11:51:35 --> Page Missing: testimonial
ERROR - 2014-09-10 11:51:40 --> Page Missing: testimonial
ERROR - 2014-09-10 11:51:58 --> Page Missing: test
ERROR - 2014-09-10 11:52:29 --> Page Missing: test
ERROR - 2014-09-10 11:52:34 --> Page Missing: users/testimonial
ERROR - 2014-09-10 11:56:39 --> Severity: Notice  --> Undefined variable: hide /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 8
ERROR - 2014-09-10 11:56:39 --> Severity: Notice  --> Undefined variable: _user /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 11:56:39 --> Severity: Notice  --> Trying to get property of non-object /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 12:44:53 --> Severity: Notice  --> Undefined variable: data /var/www/html/referralsystem/php/system/cms/modules/users/controllers/users.php 1267
ERROR - 2014-09-10 12:44:53 --> Severity: Notice  --> Use of undefined constant uri_string - assumed 'uri_string' /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 4
ERROR - 2014-09-10 12:44:53 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 12:44:53 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 12:45:21 --> Severity: Notice  --> Undefined variable: data /var/www/html/referralsystem/php/system/cms/modules/users/controllers/users.php 1267
ERROR - 2014-09-10 12:45:21 --> Severity: Notice  --> Use of undefined constant uri_string - assumed 'uri_string' /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 4
ERROR - 2014-09-10 12:45:21 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 12:45:21 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 12:45:26 --> Page Missing: uri_string
ERROR - 2014-09-10 12:45:48 --> Severity: Notice  --> Undefined variable: data /var/www/html/referralsystem/php/system/cms/modules/users/controllers/users.php 1267
ERROR - 2014-09-10 12:45:48 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 12:45:48 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 12:45:52 --> Severity: Notice  --> Undefined property: CI::$merchant_model /var/www/html/referralsystem/php/system/cms/libraries/MX/Controller.php 57
ERROR - 2014-09-10 12:45:57 --> Severity: Notice  --> Undefined variable: data /var/www/html/referralsystem/php/system/cms/modules/users/controllers/users.php 1267
ERROR - 2014-09-10 12:45:57 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 12:45:57 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 12:46:28 --> Severity: Notice  --> Undefined variable: data /var/www/html/referralsystem/php/system/cms/modules/users/controllers/users.php 1267
ERROR - 2014-09-10 13:01:51 --> Severity: Notice  --> Undefined property: CI::$merchant_model /var/www/html/referralsystem/php/system/cms/libraries/MX/Controller.php 57
ERROR - 2014-09-10 13:02:51 --> Severity: Notice  --> Undefined property: CI::$merchant_model /var/www/html/referralsystem/php/system/cms/libraries/MX/Controller.php 57
ERROR - 2014-09-10 13:03:08 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 13:03:08 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 13:04:07 --> Severity: Notice  --> Undefined property: CI::$merchant_model /var/www/html/referralsystem/php/system/cms/libraries/MX/Controller.php 57
ERROR - 2014-09-10 13:06:39 --> Severity: Notice  --> Undefined property: CI::$merchant_model /var/www/html/referralsystem/php/system/cms/libraries/MX/Controller.php 57
ERROR - 2014-09-10 13:07:05 --> Severity: Notice  --> Undefined property: CI::$validation_rules /var/www/html/referralsystem/php/system/cms/libraries/MX/Controller.php 57
ERROR - 2014-09-10 13:08:47 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 13:08:47 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 13:09:30 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 13:09:30 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 13:09:51 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 13:09:51 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 13:14:00 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 13:14:00 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 13:41:42 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 13:41:42 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 13:41:55 --> Severity: Notice  --> Undefined property: stdClass::$topic /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 12
ERROR - 2014-09-10 13:41:55 --> Severity: Notice  --> Undefined property: stdClass::$description /var/www/html/referralsystem/php/system/cms/modules/users/views/testimonial.php 16
ERROR - 2014-09-10 14:01:46 --> Query error: Unknown column 'amt' in 'field list' - Invalid query: INSERT INTO `default_testmonial` (`user_id`, `topic`, `amt`, `created_at`) VALUES (1, 'this is my feedback', 'this is derails for testing in the form of user this is data for testing due to test in the form of data life is the pat', '2014-09-10 14:01:46')
