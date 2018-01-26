<?php
/**
 * @package SchemaForArticle\Main
 */

// Make sure we don't expose any info if called directly
if ( ! defined( 'ABSPATH' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if ( ! function_exists( 'add_action' ) || ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'SCHEMA_FOR_ARTICLE_PLUGIN_VERSION', '0.3.3' );

if ( ! defined( 'SCHEMA_FOR_ARTICLE_PATH' ) ) {
	define( 'SCHEMA_FOR_ARTICLE_PATH', plugin_dir_path( SCHEMA_FOR_ARTICLE_FILE ) );
}

if ( ! defined( 'SCHEMA_FOR_ARTICLE_BASENAME' ) ) {
	define( 'SCHEMA_FOR_ARTICLE_BASENAME', plugin_basename( SCHEMA_FOR_ARTICLE_FILE ) );
}

if( is_admin() ) {
	require_once( SCHEMA_FOR_ARTICLE_PATH . 'admin/class-schema-for-article-admin.php' );
	new Schema_For_Article_Admin();

	register_uninstall_hook( SCHEMA_FOR_ARTICLE_FILE, 'schema_article_plugin_uninstall' );
} else {
	require_once( SCHEMA_FOR_ARTICLE_PATH . 'frontend/class-schema-for-article.php' );
	new Schema_For_Article();
}

/**
 * Remove Option on uninstalling/deleting the Plugin.
 */
function schema_article_plugin_uninstall() {
	delete_option( 'schema_for_article_settings' );
}

/**
 * Add textdomain hook for translation
 */
function schema_article_plugin_textdomain() {
	if ( SCHEMA_FOR_ARTICLE_PLUGIN_VERSION !== get_option( 'schema_for_article_plugin_version' ) ) {
		require_once(
			SCHEMA_FOR_ARTICLE_PATH . 'admin/class-schema-for-article-admin-options.php'
		);
		new Schema_For_Article_Admin_Options();
	}

	load_plugin_textdomain( 'schema-for-article', FALSE,
		basename( dirname( SCHEMA_FOR_ARTICLE_FILE ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'schema_article_plugin_textdomain' );
