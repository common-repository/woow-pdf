=== PDF Compression & Watermarking - WoowPDF ===
Version: 1.1.0
Author: Workforce Commerce
Author URI: https://workforcecommerce.com/
Contributors: https://profiles.wordpress.org/woowpdf/
Tags: compress, watermark, pdf
Requires at least: 5.3
Tested up to: 6.6.1
Stable tag: 1.1.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A wordpress plugin by WoowPDF.

== Description ==

Compress your PDF files and add image or text watermark with the Official WoowPDF plugin for WordPress. Optimize and watermark your PDFs automatically, just like on woowpdf.com.

###How it works

Currently, the plugin operates in a single, automatic mode.

**Compress PDF:** Whenever a PDF file is uploaded to your Media Library, it is compressed using our WoowPDF API and saved on your WordPress site in an optimized form, helping you save disk space. This feature can be disabled if desired.

**Watermark PDF:** Whenever a PDF file is uploaded to your Media Library, it is watermarked by our WoowPDF API and saved in your WordPress. This feature can be disabled.

###Automatic process

All tools are automatically applied when a PDF file is uploaded, so you no longer need to apply them manually.

== Installation ==

**From your Admin panel:**
1. Go to Plugins > Add New.
2. Search for 'WowPDF' and click the 'Install Now' button.
3. Activate the plugin on your Plugins page.

**Manually:**:
1. Upload `woow-pdf` to the `/wp-content/plugins/` directory.
2. Activate the plugin via the 'Plugins' menu in WordPress.
3. Configure the plugin to your preferences.

== Configure WoowPDF Settings ==

Install this plugin and go to Settings -> WoowPDF -> 'General' tab, select 'Yes' or 'No' if you want to backups the original pdf files.

By going to Settings -> WoowPDF -> 'Compress PDF' tab, you can enable or disable PDF compression and set your preferred compression level to optimize your PDF files. We strongly recommend using 'Default Compress,' as it provides the ideal balance between compression and quality. By enabling this tab, it will automatically compress newly uploaded PDF files.

By going to Settings -> WoowPDF -> 'Add Watermark' tab, You have the flexibility to customize various watermark preferences for your PDF files, including what to watermark(text, image) and how. By enabling this tab, it will automatically watermarked newly uploaded PDF files.

== Use of WoowPDF API Service ==

This plugin uses their own API URL to compress or add watermark to PDF files uploaded by users.
The following information is relevant to this service:

API URL: WoowPDF (https://stagingapis.woowapis.online/pdftools/)
Terms & Conditions: WoowPDF Terms & Conditions (https://woowpdf.com/terms-and-conditions)
Privacy Policy: WoowPDF Privacy Policy (https://woowpdf.com/privacy-policy)

When using this plugin, the uploaded PDF files are sent to the WoowPDF API URL for processing. This includes file compression and watermarking as specified by the user. The data sent includes the file itself and any associated metadata necessary for the processing task.

== Frequently Asked Questions ==

= Does this service come at no cost? =

Yes, this plugin provides its services for free.

== Screenshots ==

1. Configure 'General' settings
2. Configure 'Compress PDF' settings
3. Configure 'Add Watermark' text settings
4. Configure 'Add Watermark' image settings

== Changelog ==

= 1.1.0 =

Fixed
* Formatting files according to php/wordpress standards
* Used wp_enqueue functions for including JS and CSS files
* Code documentation
* Used WordPress HTTP API
* Matched text domain and plugin slug
* Added prefix to functions
* Added execution code on all PHP files
* Updated readme

= 1.0.0 =
* Initial version.