=== WP Clickcha ===
Contributors: iDope
Donate link: http://clickcha.com/
Tags: spam, antispam, anti-spam, comments, comment, captcha, clickcha, comment spam
Requires at least: 2.3
Tested up to: 2.8.4
Stable tag: trunk

Clickcha is a very unique & secure CAPTCHA that requires just one click instead of typing characters.

== Description ==

Clickcha is a unique CAPTCHA system that more secure than traditional text based CAPTCHAs yet easier to use. Clickcha will replace the Wordpress post comment button with an image based CAPTCHA that requires a single click to solve *and* post the comment.

[Click here](http://clickcha.com/demo/ "Clickcha Demo") to see Clickcha in action.

= Features =

1. The simplest CAPTCHA out there - solved in one click - no typing required.
2. Every Clickcha puzzle is unique.
3. New challenging (for bots) puzzle types regularly added.
4. Adds almost zero overhead.
5. Compatible with all cache plugins (including WP-Cache).
6. Works out of the box without any setup or editing .php files.

= How It Works =

Clickcha generates image based CAPTCHAs which require the user to click the image in a particular area to solve the puzzle. Clickcha is more secure than traditional text based CAPTCHAs which can be read via OCR software.

= Feedback =

Please let me know what you think about the plugin and any suggestions you may have. If you use the plugin please rate it. If it doesn't work for you do let me know so I can fix it.

[Post Feedback](http://wordpress.org/tags/wp-clickcha?forum_id=10#postform "Post your feedback, suggestions or bug reports")

== Installation ==

1. Upload `clickcha.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Clickcha settings in the Wordpress admin to set your API keys (you can get your free API keys on the same page)

*Note 1:* If you have Wordpress 2.7 or above you can simply go to ‘Plugins’ > ‘Add New’ in the Wordpress admin and search for “clickcha” and install it from there.

*Note 2:* If your WordPress theme doesn't have the `comment_form` hook (i.e. Clickcha won't show up with the comment form), enter the following code right before the closing `</form>` tag in the `comments.php` file of the theme.

`<?php do_action('comment_form', $post->ID); ?>`

== Frequently Asked Questions ==

= How does Clickcha work? =

Clickcha generates image based CAPTCHAs which require the user to click the image in a particular area to solve the puzzle.

= Is Clickcha better than Akismet? =

That is not a proper comparison. Akismet blocks comment spam by analyzing its content while Clickcha does so by using a very unique CAPTCHA that simple for humans but almost impossible for bots to solve. I would suggest using Clickcha in conjunction with Akismet for best results.

= I have activated the plugin and added the API keys but Clickcha does not appear on my comment forms? =

Usually this happens when:

* You are logged-in (Clickcha is bypassed for logged-in users). Try logging out and you should see it.
* Your WordPress theme doesn't have the `comment_form` hook (see installation section for info).

= Is JavaScript required to comment? =

Yes, Clickcha plugin for Wordpress does require Javascript (we might add an option to make it work without Javascript in the future).

= Are Cookies required to comment? =

No, Clickcha does not use cookies.

= What happens with pingbacks and trackbacks? =

Clickcha does not filter pingbacks and trackbacks.

= Does Clickcha support other languages? =

Yes, currently English, German, Russian, French and Spanish are supported (for the text shown within Clickcha image). If you wish to help with the translations please [contact us](http://clickcha.com/feedback/ "Contact").

= Is Clickcha available for platforms other than Wordpress? =

A [Clickcha Plugin for bbPress](http://bbpress.org/plugins/topic/clickcha/ "Clickcha for bbPress") is available. More plugins will be added soon.

= Can you add a feature X? =

Let me know, I will try if its useful enough and I have time for it.

== Screenshots ==

1. Clickcha screenshot ([Try the live demo](http://clickcha.com/demo/ "Clickcha Demo"))

== Changelog ==

= 0.7 =
* Added option to show/hide Clickcha link.

= 0.6 =
* Added option to display some text before Clickcha.
* Tested upto Wordpress 2.8.1

= 0.5 =
* Bypass clickcha for logged-in users (except users with the 'subscriber' role)

= 0.4 =
* Added workaround to a bug in IE6 that renders an incorrect height when you specify “height: auto” for an image.