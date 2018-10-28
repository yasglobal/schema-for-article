=== SCHEMA for Article ===
Contributors: sasiddiqui, aliya-yasir
Donate link: https://www.paypal.me/yasglobal
Tags: json-ld, markup, schema, rich snippets, structured data, SEO, schema.org, schema markup, JSON, google validated
Requires at least: 4.0
Tested up to: 5.0
Stable tag: 0.4.1
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 5.2

SCHEMA for Article is simply the easiest solution to add valid schema.org as a JSON script in the head of blog posts or articles.

== Description ==

Search engines such as Google are using structured data markup in many ways—for example, to create rich snippets in search results. Search results with rich snippets will improve your click through rates and increase the number of visitors on your website.

This plugin helps:

* Helps your site to earn rich snippets in Google's SERP.
* Does not depend on other plugins or external code.
* Is simple to install: plug-and-play, no need to configure anything.

=== Compatibility ===
This version requires php 5.4 for some options of json_encode. If you encounter any problems with the plugin you should check your website php version.


=== Filter ===

==== Exclude PostType from the Plugin ====

To exclude the plugin to be worked on any PostType. Add this filter in your themes functions.php.
`
function yasglobal_exclude_post_types( $post_type ) {
  if ( $post_type == 'post' ) {
    return '__false';
  }
  return '__true';
}
add_filter( 'schema_for_article_exclude_post_type', 'yasglobal_exclude_post_types');
`

=== Thanks for the Support ===

The support from the users that love SCHEMA for Article is huge. You can support SCHEMA for Article future development and help to make it even better by giving a 5 star rating with a nice message to me :)

=== Bug reports ===

Bug reports for SCHEMA for Article are [welcomed on GitHub](https://github.com/yasglobal/schema-for-article). Please note GitHub is not a support forum, and issues that aren't properly qualified as bugs will be closed.

== Installation ==

This process defines you the steps to follow either you are installing through WordPress or Manually from FTP.

**From within WordPress**

1. Visit 'Plugins > Add New'
2. Search for SCHEMA for Article
3. Activate SCHEMA for Article from your Plugins page.
4. Go to "after activation" below.

**Manually**

1. Upload the `schema-for-article` folder to the `/wp-content/plugins/` directory
2. Activate SCHEMA for Article through the 'Plugins' menu in WordPress
3. Go to "after activation" below.

**After activation**

1. Go to the plugin settings page and set up the plugin for your site.
2. You're done!

== Frequently Asked Questions ==

= Q. Why should I install this plugin? =
A. Installing this plugin is the easiest way to add structured data to your blog. The plugin automatically creates the JSON-LD according to Google's specification.

= Q. Does this plugin improve my SEO rankings? =
A. We cannot promise it - but installing this plugin is in any case a step in right direction.

= Q. Does image necessarily to be provided to activate the plugin? =
A. Yes, Incase the fearuted image is not provided by the author so, the defualt provided image would be use to validate the google structure data.

== Changelog ==

= 0.4.1 - Oct 28, 2018 =
  * Enhancement
    * Use Meta Description of Yoast if available otherwise post_excerpt is used

= 0.4 - Sept 10, 2018 =
  * Enhancement
    * Added filter to exclude schema from PostTypes
    * Added Privacy Policy content for Admin

= 0.3.3 - Jan 26, 2018 =

  * Update Translation PATH and fixed spelling typos

= 0.3.2 - Jan 19, 2018 =

  * Enhancements
    * Added translation Capability
    * Fixed PHP Notice on 404 Page
    * Fixed plugin_loaded issue

= 0.3.1 =

  * Add Compatibility with Make Paths Relative Plugin

= 0.3 =

  * Optimized the Queries and made the SCHEMA more flexible.

= 0.2 =

  * Fixed Featured Image bug and add functionality to change the SCHEMA type.

= 0.1 =

  * This is a fully functional version based on the idea of minimum viable product.
