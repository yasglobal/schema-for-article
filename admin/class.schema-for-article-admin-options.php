<?php

/**
 * @package SchemaForArticle\Admin
 */

class Schema_For_Article_Admin_Options {

  public static function update_options() {
    $schema_article_image = get_option('schema_article_image');
    $schema_article_org_name = get_option('schema_article_org_name');
    $schema_article_logo = get_option('schema_article_logo');
    if( !empty($schema_article_image) && !empty($schema_article_org_name) && !empty($schema_article_logo) ) {
      $schema_for_article_settings =  array(
        'activate'  =>  esc_attr(get_option('schema_article_activate')),
        'type'      =>  esc_attr(get_option('schema_article_type')),
        'image'     =>  esc_attr($schema_article_image),
        'org_name'  =>  esc_attr($schema_article_org_name),
        'logo'      =>  esc_attr($schema_article_logo)
      );
      update_option('schema_for_article_settings', serialize( $schema_for_article_settings ) );

      delete_option('schema_article_activate');
      delete_option('schema_article_type');
      delete_option('schema_article_image');
      delete_option('schema_article_org_name');
      delete_option('schema_article_logo');
    }
    update_option('schema_for_article_plugin_version', '0.3');
  }
}