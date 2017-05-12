=== Feedaty Plugin ===
Requires at least: 3.0
Tested up to: 4.7
Stable tag: 4.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Feedaty is a tool that helps online shops to collect, analyze and distribute authentic customer reviews from their real shoppers. Thanks to genuine and fresh content continuously collected, Feedaty will help shops increase conversion rates by communicating trustability to customers and maximize organic and paid results, thanks to Feedaty’s integration with Google. 

== Description ==

Feedaty works in a few simple steps:
1. With Feedaty, final customers will automatically receive emails inviting them to submit ratings and reviews on the shopping experience and on the purchased products.
2. Feedaty will then verify and control all contents, in order to protect transparency and quality of the published reviews.
3. Shops can access a simple Dashboard to setup their account and access real time collected reviws
4. Shops are also given tools to read/analyse content real time and to publish reviews on the web and on it’s pages (with simple widgets).
5. Conversion rates increases as well as SEO positioning
6. Shops can activate Google Seller Rating to have ratings appear also on Google Shopping and Adwords


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/feedaty-plugin` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Se the Feedaty->Feedaty Global screen to configure the plugin or click on direct link 'settings' on successfull activation message (!this step is required)
4. Enter MerchantCode and ClientSecret and save settings to configure the plugin (use credentials given in your feedaty area ) 
5. Select your preferences for badges on Feedaty->Feedaty Product Badge and save settings to see product's badge.
6. Select your preferences for badges on Feedaty->Feedaty Store Badge, save settings and insert generated widget on desired widget area from wordpress widget menu to see merchant's badge.


== Frequently Asked Questions ==

= Why the product's or the merchant's Badge or their Rich Snippets doesn't appear? =

If the Merchant or product haven't at least one review, respective badges and rich snippets doesn't appear.

= Why I can't export orders in the csv? =

Check your permission on csv directory in feedaty-plugin dir.

== Changelog ==
= 2.0.6 =
* Add a control on the http response code from Feedaty API server
* Add a timeout for requests to Feedaty Servers

= 2.0.5 =
* Fix direct access to files to improve security
* Add to cache system product reviews
* Fix cache system, before this fix the sometimes cache didn't work
* Fix class names to avoid conflicts
* Update to Wordpress code convention for paths declaration

= 2.0.4 =
* Add a default message for products without reviews
* Fix security related bugs (escape data, validate and sanitize)
* Update to Wordpress code convention for paths declaration

= 2.0.3 =
* add to ache rich snippets

= 2.0.1 =
* Dynamic configuraton for Badges
* Display rich snippets
* Fix security related bugs
* Change user id with it's own e-mail
* Send e-mail in biller's locale language

= 2.0.0 =
* Feedaty plugin.

== Upgrade Notice ==
= 2.0.6 =
This version add a control on http status code, if Feedaty server has an issue this control avoid display errors on front end

= 2.0.5 =
This version fixes some security related bugs.  Upgrade immediately.
This version improve cache management to speed up page load.

= 2.0.4 =
This version fixes some security related bugs.  Upgrade immediately.
In this version we add a default message for products without reviews.

= 2.0.3 =
With this version we cache rich snippets for speed up page load

= 2.0.1 =
This version fixes some security related bugs.  Upgrade immediately.
This version also make easy to insert badges on your site.

= 2.0.0 =
This version fixes a security related bug.  Upgrade immediately.

== Feedaty Funcionality ==

1. Send orders details to feedaty platform
2. Display product's and Merchant's badge with average score for reviews
3. Display product's related reviews
4. Display rich snippets for google
