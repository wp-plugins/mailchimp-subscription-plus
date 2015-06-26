=== MailChimp Subscription Plus ===
Contributors: finalwebsites
Donate link: http://www.finalwebsites.com/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: mailchimp, subscription, subscribe form, ajax forms, email marketing, mailing list, forms, api, ajax, email form, shortcode, clicky, Google Analytics, tracking
Requires at least: 3.0
Tested up to: 4.2.2
Stable tag: 1.0.2.1

Increase the count of new subscribers for your blog or website by using MailChimp and some professional subscription form.

== Description ==

Email marketing is still one of the best ways to drive traffic to your website. You can use this WordPress plugin to add a MailChimp subscription form below your blog, right in your articles or on other places using the widget. The Ajax technology takes care about that visitor doesn't have to leave your website while the form data gets submitted. The idea for this plugin came up because I created a new mailing list for my website. By using the RSS-driven campaign feature from MailChimp, it's possible to send new blog posts to my website's subscribers. 

= Check the features: =

* Add the subscription form to any page or post by using a shortcode or just include for all blog posts
* Add the form into your blog's sidebar using the widget
* Using nonces for simple form value validation
* The visitor stays on your website while submitting the form data
* You can change/translate all plugin text by using a localization tool
* The form HTML is compatible with the Bootstrap CSS framework (v3)
* Optional: use the CSS style-sheet included with the plugin
* Track succesfully submitted forms in Google Analytics and Clicky
* The plugin includes JS and CSS files only if the form is present (there is also an option to include these files sitewide)

There are several other plugins with a similar function, but I think my approach is better to get more subscriptions. To use this plugin you need a working MailChimp account, a fully configured mailing list and a MailChimp API key. [Click here](http://eepurl.com/r54KL) to open a free MailChimp account (good for 2000 subscribers and 12000 emails/month).

The plugin doesn't use the official MailChimp API wrapper and instead the super-simple [MailChimp API v2 wrapper](https://github.com/drewm/mailchimp-api/) provided by [Drew McLellan](http://allinthehead.com/).


== Installation ==

The quickest method for installing the MailChimp subscription form is:

1. Automatically install using the built-in WordPress Plugin installer or...
1. Upload the entire `mailchimp-subscription-plus` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Enter your MailChimp API key, the mailing list ID and the other options on the plugin settings page.
1. Add the shortcode [FWSSubscriptionForm] into the page of your choice or enable the form for all blog posts.

== Frequently Asked Questions ==

= The subscription form doesn't work, the first name isn't passed to the MailChimp list =

Compare the merge fields you're using for the plugin settings and for your MailChimp mailing list. They need to be identical, use only the characters between the pipe symbols (|), check the [MC manual](http://kb.mailchimp.com/lists/managing-subscribers/manage-list-and-signup-form-fields) for information how to add additional merge fields

= How to add a manual goal in Clicky? =

If you use a Clicky premium plan it's possible to track Goals.

1. In Clicky, visit: Goals > Setup > Create a new goal.
1. Enter a name for the goal
1. Check the "Manual Goal" checkbox and click Submit
1. Copy/paste the ID into the corresponding field on the plugin options page

== Screenshots ==
1. Settings for the *MailChimp Subscription Plus* plugin.
2. An example how the subscription form looks like.
3. Subscription form widget (Made together with the theme called "The Bootstrap")

== Changelog ==

= 1.0.2.1 =

* Bugfixes
	* jQuery shows a warning (in the console only) because of the form field "email" type and the "invalid" title atttribute used as default or info. This is fixed by using the "text" type instead.
	* Fixed also the (Dutch) language files...

= 1.0.2 =

* Enhancement
	* The form short code has two new attributes: title and description
	* There is a new option to include the JS/CSS files on all pages.

* Other
	* I changed the HTML for the shorcode for fws-subscribeform-msg (div to p)
	* Removed the namespace declaration inside the Mailchimp wrapper class (for backward compatibility with PHP 5.2)
	* The plugin is tested for WordPress 4.2
	* To improve your site's speed, the JS file is loaded now in the footer section 
	* Added a working .pot file for translations


= 1.0.1.1 =

* Bugfixes
	* Changed the way how the JavaScript code works. In the old version it wasn't possible to have more than one subscription form on the same page (f.e. below the content and using the widget).
	* The object name used for wp_localize_script is changed because of possible conflicts with other plugins or themes.

= 1.0.1 =

* Other
	* Fixed some typo's and changed some information
	* Moved some PHP files into the new "includes" directory
	* Added a new screenshot for the widget

* Enhancement
	* Added the subscription form widget
	* It's possible now to translate the complete plugin

= 1.0 =
* Initial release

