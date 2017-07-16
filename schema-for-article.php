<?php 

/**
 * @package SchemaForArticle\Main
 */

/**
 * Plugin Name: SCHEMA for Article
 * Plugin URI: https://wordpress.org/plugins/schema-for-article/
 * Description: SCHEMA for Article is simply the easiest solution to add valid schema.org as a JSON script in the head of blog posts or posts. The provided LD-JSON is validated from the google structured data.
 * Version: 0.3
 * Donate link: https://www.paypal.me/yasglobal
 * Author: YAS Global Team
 * Author URI: https://www.yasglobal.com/web-design-development/wordpress/schema-article/
 * License: GPL v3
 */

/**
 *  SCHEMA for Article Plugin
 *  Copyright (C) 2016-2017, Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.

 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.

 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Make sure we don't expose any info if called directly
if( !defined('ABSPATH') ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

if( !function_exists("add_action") || !function_exists("add_filter") ) {
  header( 'Status: 403 Forbidden' );
  header( 'HTTP/1.1 403 Forbidden' );
  exit();
}

if( !defined('SCHEMA_FOR_ARTICLE_PLUGIN_VERSION') ) {
  define('SCHEMA_FOR_ARTICLE_PLUGIN_VERSION', '0.3');
}

if( !defined('SCHEMA_FOR_ARTICLE__PLUGIN_DIR') ) {
  define('SCHEMA_FOR_ARTICLE__PLUGIN_DIR', plugin_dir_path( __FILE__ ));
}

if( !is_admin() ) {
  require_once(SCHEMA_FOR_ARTICLE__PLUGIN_DIR.'frontend/class.schema-for-article.php');   
  add_action( 'init', array( 'Schema_For_Article', 'init' ) );
} else {
  require_once(SCHEMA_FOR_ARTICLE__PLUGIN_DIR.'admin/class.schema-for-article-admin.php');
  add_action( 'init', array( 'Schema_For_Article_Admin', 'init' ) );

  $plugin = plugin_basename(__FILE__); 
  add_filter("plugin_action_links_$plugin", 'schema_article_settings_link' );
}

function schema_article_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=schema-article-settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

function schema_article_plugin_check_version() {
  if( SCHEMA_FOR_ARTICLE_PLUGIN_VERSION !== get_option('schema_for_article_plugin_version') ) {
    require_once(SCHEMA_FOR_ARTICLE__PLUGIN_DIR.'admin/class.schema-for-article-admin-options.php');
    $schema_options = new Schema_For_Article_Admin_Options; 
    $schema_options->update_options();
  }
}
add_action('plugins_loaded', 'schema_article_plugin_check_version');
