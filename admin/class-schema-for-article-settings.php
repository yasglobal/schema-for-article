<?php
/**
 * @package SchemaForArticle\Admin
 */

class Schema_For_Article_Settings {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->schema_settings();
	}

	/**
	 * Schema Settings
	 */
	private function schema_settings() {
		if( isset( $_POST['submit'] ) ) {
			$activate_schema = '';
			if ( isset( $_POST['schema_article_activate'] ) ) {
				$activate_schema = $_POST['schema_article_activate'];
			}
			$schema_settings =  array(
				'activate' => $activate_schema,
				'type'     => esc_attr( $_POST['schema_article_type'] ),
				'image'    => esc_attr( $_POST['schema_article_image'] ),
				'org_name' => esc_attr( $_POST['schema_article_org_name'] ),
				'logo'     => esc_attr( $_POST['schema_article_logo'] )
			);
			update_option( 'schema_for_article_settings',
				serialize( $schema_settings )
			);
		}
		$get_settings = unserialize( get_option('schema_for_article_settings') );
		$schema_activated_checked = '';
		if( isset( $get_settings ) && ! empty( $get_settings ) ) {
			$schema_activated = $get_settings['activate'];
			$schema_type      = $get_settings['type'];
			$schema_image     = $get_settings['image'];
			$schema_name      = $get_settings['org_name'];
			$schema_logo      = $get_settings['logo'];
			$article_checked  = 'selected="selected"';
			$news_checked     = '';
			if ( $schema_type != '' && $schema_type == 'NewsArticle' ) {
				$article_checked = '';
				$news_checked    = 'selected="selected"';
			}
			if ( empty( $schema_name ) ) {
				$schema_name = get_bloginfo( 'name' );
			}
			if ( $schema_activated == 'on' ) {
				$schema_activated_checked = 'checked';
			}
		} else {
			$schema_name = get_bloginfo( 'name' );
			$schema_image = $schema_logo = '';
		}
		wp_enqueue_style( 'style', plugins_url( '/admin/css/admin-style.min.css', SCHEMA_FOR_ARTICLE_FILE ) );
		?>
		<div class="wrap">
			<h1><?php _e( 'SCHEMA.ORG ARTICLE SETTINGS', 'schema-for-article' ); ?></h1>
			<div><?php _e( 'Define the Article/NewsArticle Schema Structure for your Website.', 'schema-for-article' ); ?></div>
			<form enctype="multipart/form-data" method="POST" action="" id="schema-for-article">
				<table class="schema-admin-table">
					<caption><?php _e( 'Basic Setting', 'schema-for-article' ); ?></caption>
						<tr>
							<th><?php _e( 'Type', 'schema-for-article' ); ?>: </th>
							<td>
								<select name="schema_article_type">
									<option value="Article" <?php echo $article_checked; ?>><?php _e( 'Article', 'schema-for-article' ); ?></option>
									<option value="NewsArticle" <?php echo $news_checked; ?> ><?php _e( 'NewsArticle', 'schema-for-article' ); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th><?php _e( 'headline', 'schema-for-article' ); ?> :</th>
							<td><small><?php _e( 'Default : post_title', 'schema-for-article' ); ?></small></td>
						</tr>
						<tr>
							<th><?php _e( 'datePublished', 'schema-for-article' ); ?> :</th>
							<td><small><?php _e( 'Default : get_the_time( DATE_ISO8601, ID )', 'schema-for-article' ); ?></small></td>
						</tr>
						<tr>
							<th><?php _e( 'dateModified', 'schema-for-article' ); ?> :</th>
							<td><small><?php _e( 'Default', 'schema-for-article' ); ?> : get_the_modified_time( DATE_ISO8601, false, ID )</small></td>
						</tr>
						<tr>
							<th><?php _e( 'description', 'schema-for-article' ); ?> :</th>
							<td><small><?php _e( 'Default', 'schema-for-article' ); ?> : post_excerpt</small></td>
						</tr>
				</table>

				<table class="schema-admin-table">
					<caption><?php _e( 'mainEntityOfPage ( recommended )', 'schema-for-article' ); ?></caption>
					<tr>
						<th><?php _e( '@type', 'schema-for-article' ); ?> :</th><td><small>"<?php _e( 'WebPage', 'schema-for-article' ); ?>"</small></td>
					</tr>
					<tr>
						<th><?php _e( '@id', 'schema-for-article' ); ?> :</th>
						<td><small><?php _e( 'Default', 'schema-for-article' ); ?> : get_permalink( ID )</small></td>
					</tr>
				</table>

				<table class="schema-admin-table">
					<caption><?php _e( 'image ( required )', 'schema-for-article' ); ?></caption>
					<tr>
						<th><?php _e( '@type', 'schema-for-article' ); ?> :</th>
						<td><small>"<?php _e( 'ImageObject', 'schema-for-article' ); ?>"</small></td>
					</tr>
					<tr>
						<th><?php _e( 'url', 'schema-for-article' ); ?> :</th>
						<td>
							<label for="upload_image">
								<input type="text" name="schema_article_image" id="logo" class="regular-text" required value="<?php echo $schema_image; ?>" />
								<small><?php _e( 'Default: thumbnail(Featured Image)<br>When Featured image is not available then this image would be shown in the markup.', 'schema-for-article' ); ?></small>
							</label>
						</td>
					</tr>
					<tr>
						<th><?php _e( 'height', 'schema-for-article' ); ?> :</th>
						<td><small><?php _e( 'Auto : The height of the image, in pixels.', 'schema-for-article' ); ?></small></td>
					</tr>
					<tr>
						<th><?php _e( 'width', 'schema-for-article' ); ?> :</th>
						<td><small><?php _e( 'Auto : The width of the image, in pixels. Images should be at least 696 pixels wide.', 'schema-for-article' ); ?></small></td>
					</tr>
				</table>

				<table class="schema-admin-table">
					<caption><?php _e( 'publisher( required )', 'schema-for-article' ); ?></caption>
					<tr>
						<th><?php _e( '@type', 'schema-for-article' ); ?> :</th>
						<td><small><?php _e( '"Organization', 'schema-for-article' ); ?>"</small></td>
					</tr>
					<tr>
						<th><label for="name"><?php _e( 'Organization Name :', 'schema-for-article' ); ?></label></th>
						<td><input type="text" name="schema_article_org_name" id="name" class="regular-text" required value="<?php echo $schema_name; ?>" /><small><?php _e( 'Default : bloginfo("name")', 'schema-for-article' ); ?></small></td>
					</tr>
				</table>

				<table class="schema-admin-table">
					<caption><?php _e( 'logo ( required )', 'schema-for-article' ); ?></caption>
					<tr>
						<th><?php _e( '@type', 'schema-for-article' ); ?> :</th>
						<td><small>"<?php _e( 'ImageObject', 'schema-for-article' ); ?>"</small></td>
					</tr>
					<tr>
						<th><label for="logo"><?php _e( 'url :', 'schema-for-article' ); ?></label></th>
						<td><input type="text" name="schema_article_logo" id="logo" class="regular-text" required value="<?php echo $schema_logo; ?>" /></td>
					</tr>
					<tr>
						<th><?php _e( 'height', 'schema-for-article' ); ?> :</th>
						<td><small><?php _e( 'Auto : height >= 60px.', 'schema-for-article' ); ?></small></td>
					</tr>
					<tr>
						<th><?php _e( 'width', 'schema-for-article' ); ?> :</th>
						<td><small><?php _e( 'Auto : width <= 600px.', 'schema-for-article' ); ?></small></td>
					</tr>
				</table>

				<table class="schema-admin-table">
					<tbody>
						<tr>
							<td><input type="checkbox" name="schema_article_activate" value="on" <?php echo $schema_activated_checked; ?> /><strong><?php _e( 'Activate SCHEMA.ORG Article', 'schema-for-article' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<p>Setting Knowledge : <a href="https://developers.google.com/structured-data/rich-snippets/articles" target="_blank">https://developers.google.com/structured-data/rich-snippets/articles</a></p> 
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'schema-for-article' ); ?>" /></p>
			</form>
		</div>
		<?php
	}
}
