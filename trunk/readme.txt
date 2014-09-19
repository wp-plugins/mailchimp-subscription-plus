=== MailChimp Subscription Plus ===
Contributors: finalwebsites
Donate link: http://www.finalwebsites.com/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: mailchimp, subscription, subscribe form, ajax forms, email marketing, mailing list, forms, api, ajax, email form, shortcode, clicky, Google Analytics, tracking
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 1.0

Raise the count of new subscribers for your blog or website by using MailChimp and a professional subscribe form.

== Description ==

Email marketing is still one of the best ways to drive traffic to your website. You can use this WordPress plugin to add a MailChimp subscription form right below your blog or right in your article. The Ajax technologie takes care about that visitor doesn't have to leave your website while the form gets submitted. The idea for this plugin was to create a new mailing list for my website. Using the RSS-driven campaign feature from MailChimp it's possible to send new blog posts to all subscribed people.

= Check the features: =

* Add the subscription form to any page or post by using a shortcode or include the form to all your blog posts
* Using nonces for simple form value validation
* The visitor stays on your website while submitting the subscribe form
* You can change/translate all public text messages while using a localization tool
* The form HTML is compatibel with the Boostrap CSS framework
* Optional: use the CSS style-sheet included by the plugin
* Track succesfully submitted forms in Google Analytics and Clicky

There are several other plugins with a similar function, but I think my approach is better to get more subscriptions. There will be a form widget and an unsubscribe page in one of the next versions. To use this plugin you need a working MailChimp account, a fully configured mailing list and an API key. [Click here](http://eepurl.com/r54KL) to open a free MailChimp account (good for 2000 subscribers and 12000 emails/month).

The plugin doesn't use the official MailChimp API wrapper, but the super-simple [MailChimp API v2 wrapper](https://github.com/drewm/mailchimp-api/) provided by [Drew McLellan](http://allinthehead.com/).


== Installation ==

The quickest method for installing the MailChimp subscription form is:

1. Automatically install using the builtin WordPress Plugin installer or...
1. Upload the entire `fws-ajax-contact-form` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Enter your MailChimp API key, the mailing list ID and the other options on the plugin settings page.
1. Add the shortcode [FWSSubscriptionForm] into the page of your choice or enable the form for all blog posts.

== Frequently Asked Questions ==

= The subscription form doesn't work, the first name isn't passed to the MailChimp list =

Compare the merge fields you're using for the plugin settings and for your MailChimp mailing list. They need to be identical, check the [MC manual](http://kb.mailchimp.com/lists/managing-subscribers/manage-list-and-signup-form-fields) for information how to add additional merge fields

= How to add a manual goal in Clicky? =

If you use a Clicky premium plan it's possible to track Goals.

1. In Clicky click on Goals > Setup > Create a new goal.
1. Enter a name for the goal
1. Check the "Manual Goal" checkbox and click Submit
1. Copy/paste the ID into the field from the plugin options page

== Screenshots ==



== Changelog ==

= 1.0 =
* Initial release

