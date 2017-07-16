<?php 

/**
 * @package SchemaForArticle\Frontend
 */

class Schema_For_Article {
  
  private static $initiated = false;

  /**
   * Add the Schema for Article in the head on page init
   */
   public static function init() {
     if ( ! self::$initiated ) {
			self::$initiated = true;
      
      add_action ( 'wp_head', array('Schema_For_Article', 'schema_article_add_json_markup'), 0 );
     }
   }

  public static function schema_article_add_json_markup(){
    global $post;
    $schema_article_settings = unserialize( get_option('schema_for_article_settings') );
    if( isset($schema_article_settings) && !empty($schema_article_settings) && $schema_article_settings['activate'] == "on" ) {
      $schema_name = $schema_article_settings['org_name'];
      $schema_article_type = $schema_article_settings['type'];
      $schema_logo = $schema_article_settings['logo'];
      $schema_image = $schema_article_settings['image'];
      $images = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
      if( isset($images) && empty($images) ) {
        $images[0] = $schema_image;
      }
      if( empty($schema_article_type) ) {
        $schema_article_type = "Article";
      }
      $excerpt = Schema_For_Article::schema_article_escape_text_tags($post->post_excerpt);
      $content = $excerpt === "" ? mb_substr( Schema_For_Article::schema_article_escape_text_tags( $post->post_content ), 0, 110 ) : $excerpt;
      $args = array(
        "@context" => "http://schema.org",
        "@type"    => $schema_article_type,
        "mainEntityOfPage" => array(
          "@type" => "WebPage",
          "@id"   => get_permalink( $post->ID )
        ),
        "headline" => Schema_For_Article::schema_article_escape_text_tags( $post->post_title ),
        "image"    => array(
          "@type"  => "ImageObject",
          "url"    => $images[0],
          "width"  => "auto",
          "height" => "auto"
        ),
        "datePublished" => get_the_time( DATE_ISO8601, $post->ID ),
        "dateModified"  => get_post_modified_time(  DATE_ISO8601, __return_false(), $post->ID ),
        "author" => array(
          "@type" => "Person",
          "name"  => Schema_For_Article::schema_article_escape_text_tags( get_the_author_meta( 'display_name', $post->post_author ) )
        ),
        "publisher" => array(
          "@type" => "Organization",
          "name"  => $schema_name,
          "logo"  => array(
            "@type"  => "ImageObject",
            "url"    => $schema_logo,
            "width"  => "auto",
            "height" => "auto"
          )
        ),
        "description" => $content
      );
      Schema_For_Article::schema_article_set_schema_json( $args );
    }
  }

  private static function schema_article_escape_text_tags ( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
  }

  private static function schema_article_set_schema_json ( array $args ) {
    echo '<script type="application/ld+json">' , PHP_EOL;
    echo json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
    echo '</script>' , PHP_EOL;
  }
}
