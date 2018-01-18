<?php
/**
 * @package SchemaForArticle\Frontend
 */

class Schema_For_Article {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action ( 'wp_head', array( $this, 'add_json_markup' ), 0 );
	}

	/**
	 * Create JSON Markup
	 */
	public function add_json_markup() {
		global $post;
		if ( ! $post ) {
			return;
		}
		$get_settings = unserialize( get_option( 'schema_for_article_settings') );
		if ( isset( $get_settings ) && ! empty( $get_settings )
			&& $get_settings['activate'] == "on" ) {
			$schema_name  = $get_settings['org_name'];
			$schema_type  = $get_settings['type'];
			$schema_logo  = $get_settings['logo'];
			$schema_image = $get_settings['image'];
			$images       = wp_get_attachment_image_src(
				get_post_thumbnail_id( $post->ID ), 'full'
			);
			if ( isset( $images ) && empty( $images ) ) {
				$images[0] = $schema_image;
			}
			if ( empty( $schema_type ) ) {
				$schema_type = "Article";
			}
			$headline = $this->escape_text_tags( $post->post_title );
			$content  = $this->escape_text_tags( $post->post_excerpt );
			if ( $content === '' ) {
				$content = $this->escape_text_tags( $post->post_content );
				$content = mb_substr( $content, 0, 110 );
			}
			$schema_post_id = site_url() . str_replace(
				site_url(), '', get_permalink( $post->ID )
			);
			$date_published = get_the_time( DATE_ISO8601, $post->ID );
			$date_modified  = get_post_modified_time(
				DATE_ISO8601, __return_false(), $post->ID
			);
			$author_name = get_the_author_meta( 'display_name', $post->post_author );
			$author_name = $this->escape_text_tags( $author_name );
			$args = array(
				"@context" => "http://schema.org",
				"@type"    => $schema_type,
				"mainEntityOfPage" => array(
					"@type" => "WebPage",
					"@id"   => $schema_post_id
				),
				"headline" => $headline,
				"image"    => array(
					"@type"  => "ImageObject",
					"url"    => $images[0],
					"width"  => "auto",
					"height" => "auto"
				),
				"datePublished" => $date_published,
				"dateModified"  => $date_modified,
				"author" => array(
					"@type" => "Person",
					"name"  => $author_name
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
			$this->set_schema_json( $args );
		}
	}

	/**
	 * Strip Tags and replace tabs and newlines with space
	 */
	private function escape_text_tags( $text ) {
		$text = str_replace( array( '\r', '\n' ), '', strip_tags( $text ) );
		return $text;
	}

	/**
	 * Print the Schema with proper indentation
	 */
	private function set_schema_json( $args ) {
		echo '<script type="application/ld+json">', PHP_EOL;
		echo json_encode(
			$args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
		), PHP_EOL;
		echo '</script>', PHP_EOL;
	}
}
