# SCHEMA for Article

## Description

Search engines such as Google are using structured data markup in many ways—for example, to create rich snippets in search results. Search results with rich snippets will improve your click through rates and increase the number of visitors on your website.

This plugin helps:

* Helps your site to earn rich snippets in Google's SERP.
* Does not depend on other plugins or external code.
* Is simple to install: plug-and-play, no need to configure anything.

### Compatibility
This version requires php 5.4 for some options of json_encode. If you encounter any problems with the plugin you should check your web hotel's php version.

## Filters

### Exclude PostType from the Plugin

To exclude the plugin to be worked on any PostType. Add this filter in your themes functions.php.

```
function yasglobal_exclude_post_types( $post_type ) {
  if ( $post_type == 'post' ) {
    return '__false';
  }
  return '__true';
}
add_filter( 'schema_for_article_exclude_post_type', 'yasglobal_exclude_post_types');
```

### Thanks for the Support

The support from the users that love SCHEMA for Article is huge. You can support SCHEMA for Article future development and help to make it even better by donating or even giving a 5 star rating with a nice message to me :)

[Donate to SCHEMA for Article](https://www.paypal.me/yasglobal)

## Installation

### From within WordPress

1. Visit 'Plugins > Add New'
2. Search for SCHEMA for Article
3. Activate SCHEMA for Article from your Plugins page.
4. Go to "after activation" below.

### Manually

1. Upload the `schema-for-article` folder to the `/wp-content/plugins/` directory
2. Activate SCHEMA for Article through the 'Plugins' menu in WordPress
3. Go to "after activation" below.

### After activation

1. Go to the plugin settings page and set up the plugin for your site.
2. You're done!

## Frequently Asked Questions

**Q. Why should I install this plugin?**

A. Installing this plugin is the easiest way to add structured data to your blog. The plugin automatically creates the JSON-LD according to Google's specification. 

**Q. Does this plugin improve my SEO rankings?**

A. We cannot promise it - but installing this plugin is in any case a step in right direction.

**Q. Does image necessarily to be provided to activate the plugin?**

A. Yes, Incase the fearuted image is not provided by the author so, the defualt provided image would be use to validate the google structure data
