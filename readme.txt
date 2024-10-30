=== CHP Nepali Date Converter ===
Contributors: sureshchand00a
Donate link: 
Tags: Nepali, Nepali Date, Nepali Date Converter, Code Help Pro, CHP, Real timer, plugin
Requires at least: 4.0
Tested up to: 4.8
Stable tag: trunk
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

CHP Nepali Date Converter plugin is developed in order to provide dates conversion from English to Nepali dates and Vice Versa. This plugin converts pages, posts and comments date from English to Nepali or Vice Versa. This plugin also supports Shortcode that helps you to display Nepali dates anywhere in your website.

== Description ==

CHP Nepali Date Converter plugin is developed in order to provide dates conversion from English to Nepali dates and Vice Versa. This plugin converts pages, posts and comments date from English to Nepali or Vice Versa. This plugin also supports Shortcode that helps you to display Nepali dates anywhere in your website.

### Main Features
*   Show Posts, Pages, Comments Date to Nepali
*   Supports Time Diff (Eg: ३ सेकेन्ड अगाडि)
*   Time ago available for comments. Such as `३ माहिना पहिले`
*   Various Custom function to convert English Date to Nepali and Nepali Date to English
* Real Timer system

### AVAILABLE SHORTCODES
You can use following shortcodes to display Nepali Date or Today Date anywhere in the posts or pages:

*   Use `[CHPNPDATE date="YOUR_DATE"]` to show Nepali Date Converter
*   Use `[CHPNPDATE date="TODAY"]` or `[CHPNPDATE]` to show Today Date
*   Use `[CHPNPDATE date="REALTIME"]` to show Real Timer with Date
*   Use `[CHPNPDATE date="REALTIMEONLY"]` to show Real Timer without Date

### AVAILABLE FUNCTIONS

You can use following functions to display Nepali Date or Today Date:

*   Use `chp_real_time` to show Real Timer. It accepts an boolean argument (true or false), whether to show time only or timer with  full date


       <?php echo chp_real_time(false | true);  ?>

*   Use `chp_np_to_en` to convert english date to nepali date. It accepts an argument, that is YOUR_DATE


      <?php echo chp_np_to_en(DATE);  ?>

*   Use `chp_np_date` to display Nepali Date. It accepts three arguments. First is date and second is DATE FORMAT and third one is boolean(true or false) whether to show timer or not.


    <?php echo chp_np_date(DATE, DATE_FORMAT, true | false);  ?>

### AVAILABLE WIDGET

Currently Our plugin supports two widgets.
* `CHP NP Date Converter` helps you to display nepali date with or without timer
* `CHP NP Date Theme` helps you to display time and date in beautiful way.

### Working Flow
This plugin is working under a single `PHP CLASS` that converts English Date to Nepali Date. https://codehelppro.com/wordpress-plugin-development/scripts/chp-nepali-date-converter.

== Installation ==

1.  Login to admin panel, Go to Plugins => Add New.
2.  Search for “Chp Nepali Date Converter” and install it.
3.  Once you install it, activate it
4.  Go to Settings => Your can find “Chp Nepali Date Converter” option to manage settings.
    
Or
    
1.  Put the plug-in folder `chpnpdate` into \[wordpress\_dir\]/wp-content/plugins/
2.  Go into the WordPress admin interface and activate the plugin
3.  Go to Settings => Your can find “Chp Nepali Date Converter” option to manage settings.
    
Have fun!!!

== Frequently Asked Questions ==

= What does this plugin does? =

This plugin helps you to convert or display Nepali dates in your website in your own way.

= Is it Free? =

Yes, it is completely free. There is no any hidden cost.

= Who can use this plugin? =

There is no any restriction to use this plugin. If you want to display Nepali dates in your website, You can use this plugin.


== Screenshots ==

1. Admin setting
2. Help Section
3. Front Display

== Changelog ==

= 1.2 =
* Two Widget Added
* One More Function Added
* Fixes some minor issues

= 1.1.0 =
* Real timer System
* Included different functions to show nepali date or timer
* Time ago format for comments
* Fixes some minor issues
 
= 1.1.0 =
* First release of plugin


== Developers ==

* Suresh Chand