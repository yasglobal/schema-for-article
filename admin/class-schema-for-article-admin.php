<?php
/**
 * @package SchemaForArticle\Admin
 */

class Schema_For_Article_Admin {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action ( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'plugin_action_links_' . SCHEMA_FOR_ARTICLE_BASENAME,
			array( $this, 'settings_link' )
		);
	}

	/**
	 * Add Settings Pages in the Dashboard Menu.
	 */
	public function admin_menu() {
		add_menu_page( 'SCHEMA.ORG ARTICLE SETTINGS', 'SCHEMA.ORG ARTICLE',
			'administrator', 'schema-article-settings',
			array( $this, 'admin_settings_page' )
		);
		add_submenu_page( 'schema-article-settings', 'SCHEMA.ORG ARTICLE Settings',
			'Settings', 'administrator', 'schema-article-settings',
			array( $this, 'admin_settings_page' )
		);
		add_submenu_page( 'schema-article-settings', 'About Schema for Article',
			'About', 'administrator', 'schema-article-about-plugins',
			array( $this, 'about_plugin' )
		);
	}

	/**
	 * Admin Settings Page by which you can change/choose your settings
	 * according to your need.
	 */
	public function admin_settings_page() {
		if( ! current_user_can('administrator') )  {
			wp_die( 
				__( 'You do not have sufficient permissions to access this page.' )
			);
		}
		require_once(
			SCHEMA_FOR_ARTICLE_PATH . 'admin/class-schema-for-article-settings.php'
		);
		new Schema_For_Article_Settings();
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Add About Plugins Page
	 */
	public function about_plugin() {
		require_once(
			SCHEMA_FOR_ARTICLE_PATH . 'admin/class-schema-for-article-about.php'
		);
		new Schema_For_Article_About();		
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Add Plugin Support and Follow Message in the footer of Admin Pages
	 */
	public function admin_footer_text() {
		$footer_text = sprintf(
			__( 'SCHEMA for Article version %s by <a href="%s" title="YAS Global Website" target="_blank">YAS Global</a> - <a href="%s" title="Support forums" target="_blank">Support forums</a> - Follow on Twitter: <a href="%s" title="Follow YAS Global on Twitter" target="_blank">YAS Global</a>', 'schema-for-article' ),
			SCHEMA_FOR_ARTICLE_PLUGIN_VERSION, 'https://www.yasglobal.com',
			'https://wordpress.org/support/plugin/schema-for-article',
			'https://twitter.com/samisiddiqui91'
		);
		return $footer_text;
	}

	/**
	 * Add About, Contact and Settings Link on the Plugin Page under
	 * the Plugin Name.
	 */
	public function settings_link( $links ) {
		$about = sprintf(
			__( '<a href="%s" title="About">About</a>', 'schema-for-article' ),
			'admin.php?page=schema-article-about-plugins'
		);
		$contact = sprintf(
			__( '<a href="%s" title="Contact" target="_blank">Contact</a>', 'schema-for-article' ),
			'https://www.yasglobal.com/#request-form'
		);
		$settings_link = sprintf(
			__( '<a href="%s" title="Settings">Settings</a>', 'schema-for-article' ),
			'admin.php?page=schema-article-settings'
		);
		array_unshift( $links, $settings_link );
		array_unshift( $links, $contact );
		array_unshift( $links, $about );
		return $links;
	}
}
