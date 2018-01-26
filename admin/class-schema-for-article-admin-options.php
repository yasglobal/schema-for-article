<?php
/**
 * @package SchemaForArticle\Admin
 */

class Schema_For_Article_Admin_Options {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->update_options();
	}

	private function update_options() {
		$schema_image    = get_option( 'schema_article_image' );
		$schema_org_name = get_option( 'schema_article_org_name' );
		$schema_logo     = get_option( 'schema_article_logo' );
		if( ! empty( $schema_image ) && ! empty( $schema_org_name )
			&& ! empty( $schema_logo ) ) {
			$schema_settings =  array(
				'activate' => esc_attr( get_option( 'schema_article_activate' ) ),
				'type'     => esc_attr( get_option( 'schema_article_type' ) ),
				'image'    => esc_attr( $schema_article_image ),
				'org_name' => esc_attr( $schema_article_org_name ),
				'logo'     => esc_attr( $schema_article_logo )
			);
			$schema_settings = serialize( $schema_settings );
			update_option( 'schema_for_article_settings', $schema_settings );

			delete_option( 'schema_article_activate' );
			delete_option( 'schema_article_type' );
			delete_option( 'schema_article_image' );
			delete_option( 'schema_article_org_name' );
			delete_option( 'schema_article_logo' );
		}
		update_option( 'schema_for_article_plugin_version', '0.3.3' );
	}
}