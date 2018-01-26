<?php
/**
 * Plugin Name: SCHEMA for Article
 * Plugin URI: https://wordpress.org/plugins/schema-for-article/
 * Description: SCHEMA for Article is simply the easiest solution to add valid schema.org as a JSON script in the head of blog posts or posts. The provided LD-JSON is validated from the google structured data.
 * Version: 0.3.3
 * Author: YAS Global Team
 * Author URI: https://www.yasglobal.com/web-design-development/wordpress/schema-article/
 * Donate link: https://www.paypal.me/yasglobal
 * License: GPLv3
 *
 * Text Domain: schema-for-article
 * Domain Path: /languages/
 *
 * @package SchemaForArticle
 */

/**
 *  SCHEMA for Article - Structured Markup Helper for WordPress
 *  Copyright (C) 2016-2018, Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
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
if( ! defined( 'ABSPATH' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if( ! function_exists( 'add_action' ) || ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if( ! defined( 'SCHEMA_FOR_ARTICLE_FILE' ) ) {
	define( 'SCHEMA_FOR_ARTICLE_FILE', __FILE__ );
}

require_once( dirname( SCHEMA_FOR_ARTICLE_FILE ) . '/schema-for-article-main.php' );
