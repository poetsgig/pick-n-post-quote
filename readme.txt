=== Pick-n-Post Quote ===
Contributors: Amy Aulisi
Donate link: 
Tags: widget, sidebar, quote
Requires at least: 4.6.0
Tested up to: 4.9.6
Stable Tag: 1.0.2
License: GPLv2

== Description ==

Utilizes the native WordPress custom meta field. Both Gutenberg and Classic Editor supports Custom Fields. Pick-n-Post Quote plugin allows you to display a static or featured quote for the current post in the sidebar area. Displaying quote author and source is optional. Supports multiple instances of widget.

If you wish to display random quote on a current post, a plugin "Quote Collection" by Srini G already exists for this purpose.


== Installation ==

It is very simple.


 * First Method *

1. Download the plugin zip file
2. Go to your Wordpress Admin dashboard->Plugin section
3. Click on "Add New" tab, and click on the "Upload Plugin" button
4. Click on the "Choose File" button and select Pick-n-Post Quote zip file. Click "Install Now"


 * Second Method *

1. Go to your Wordpress Admin dashboard->Plugin section
2. Click on "Add new" tab
3. Enter "Pick-n-Post Quote" in the search bar
4. Select Pick-n-Post Quote plugin and click "Install Now"

 * Activation *
5. Go to your Wordpress Admin dashboard > Plugin section. The list of installed plugins will show.
6. Hover down until you see "Pick-n-Post Quote" plugin and click "Activate"

 * Widget Setup *
7. Go to Appearance->Widgets to set and configure Pick-n-Post Quote


 * Add Custom Field *
 
If you are using the Classic Editor:
1. Go to WordPress Post edit screen and select one post where you want to show a featured quote. Scroll to top of the page to see "Screen Options". Tick the "Custom Fields" checkbox.

If you are using the Gutenberg Editor:
2. Go to WordPress Post edit screen and select one post where you want to show a featured quote. Click the "three-dots" settings button on the right side and go to "Options". Scroll down until you see the option "Custom Fields". Tick the "Custom Fields" checkbox. Wait for the page to reload.

3. Scroll down until you see the "Custom Fields" meta box. Click "Enter New" to add each custom field. Note that you only need to enter a field "key" once.
	To add a quote, use "pick_n_post_quote" under Custom Field "Name". Type your quote in the "Value" area. Hit "Add Custom Field".
    To add an author, use "pick_n_post_quote_author" under Custom Field "Name". Type your author name in the "Value" area. Hit "Add Custom Field".
	To add a source, use "pick_n_post_quote_source" under Custom Field "Name". Type your source in the "Value" area. Hit "Add Custom Field".

	When there is an entry for the custom field, you can verify if the meta data value exists in wp_postmeta table in the database. For the custom field meta key to appear in the dropdown under “Add New Custom Field”, there must be at least a single value entered. 
	
4. Pick another post. Since you already entered one entry for each custom field key, they will now appear in the Add New Custom Field "Select" dropdown. You just need to enter their texts on the "Value" area.


== Upgrade Notice ==

This plugin supports WordPress installation using version 4.6.0 and later.


== Frequently Asked Questions ==


== Changelog ==

= 1.0.1 =
* Plugin is first created

= 1.0.2 =
* Supports multiple instances of widget
