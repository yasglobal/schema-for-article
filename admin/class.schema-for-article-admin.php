<?php

/**
 * @package SchemaForArticle\Admin
 */

class Schema_For_Article_Admin {
  
  private static $initiated = false;

  /**
	 * Initializes WordPress hooks
	 */
  public static function init() {
    if ( ! self::$initiated ) {
			self::$initiated = true;

      add_action( 'admin_menu', array('Schema_For_Article_Admin', 'schema_article_menu') );
		}
  }

  public static function schema_article_menu() {
    add_menu_page('SCHEMA.ORG ARTICLE SETTINGS', 'SCHEMA.ORG ARTICLE Settings', 'administrator', 'schema-article-settings', array('Schema_For_Article_Admin', 'schema_article_settings_page'));
  }

  public static function schema_article_settings_page() {
    if( !current_user_can('administrator') )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    if( isset($_POST['submit']) ) {
      $schema_for_article_settings =  array(
        'activate'  =>  esc_attr($_POST['schema_article_activate']),
        'type'      =>  esc_attr($_POST['schema_article_type']),
        'image'     =>  esc_attr($_POST['schema_article_image']),
        'org_name'  =>  esc_attr($_POST['schema_article_org_name']),
        'logo'      =>  esc_attr($_POST['schema_article_logo'])
      );
      update_option('schema_for_article_settings', serialize( $schema_for_article_settings ) );
    }
    $schema_article_settings = unserialize( get_option('schema_for_article_settings') );
    $schema_activated_checked = "";
    if( isset($schema_article_settings) && !empty($schema_article_settings) ) {
      $schema_activated = $schema_article_settings['activate'];
      $schema_article_type = $schema_article_settings['type'];
      $schema_article_image = $schema_article_settings['image'];
      $schema_name = $schema_article_settings['org_name'];
      $schema_article_logo = $schema_article_settings['logo'];      
      if(empty($schema_name)) {
        $schema_name = get_bloginfo("name");
      }
      if($schema_activated == 'on') {
        $schema_activated_checked = "checked";
      }
    } else {
      $schema_name = get_bloginfo("name");
      $schema_article_image = $schema_article_logo = "";
    }
    wp_enqueue_style( 'style', plugins_url('/css/admin-style.min.css', __FILE__) );
    ?>
    <div class="wrap">
      <h2>SCHEMA.ORG ARTICLE SETTINGS</h2>
      <div>Define the Article/NewsArticle Schema Structure for your Website. </div>
      <form enctype="multipart/form-data" method="POST" action="" id="schema-for-article">
        <table class="schema-admin-table">
          <caption>Basic Setting</caption>
            <tr>
              <th>Type: </th>
              <td>
                <select name="schema_article_type">
                  <option value="Article" <?php if ( $schema_article_type == "" || $schema_article_type != "NewsArticle" ) echo 'selected="selected"'; ?>>Article</option>
                  <option value="NewsArticle" <?php if ( $schema_article_type == "NewsArticle" ) echo 'selected="selected"'; ?> >NewsArticle</option>
                </select>
              </td>
            </tr>
            <tr>
              <th>headline :</th>
              <td><small>Default : post_title</small></td>
            </tr>
            <tr>
              <th>datePublished :</th>
              <td><small>Default : get_the_time( DATE_ISO8601, ID )</small></td>
            </tr>
            <tr>
              <th>dateModified :</th>
              <td><small>Default : get_the_modified_time( DATE_ISO8601, false, ID )</small></td>
            </tr>
            <tr>
              <th>description :</th>
              <td><small>Default : post_excerpt</small></td>
            </tr>
        </table>
      
        <table class="schema-admin-table">
          <caption>mainEntityOfPage ( recommended )</caption>
          <tr>
            <th>@type :</th><td><small>"WebPage"</small></td>
          </tr>
          <tr>
            <th>@id :</th>
            <td><small>Default : get_permalink( ID )</small></td>
          </tr>
        </table>
        
        <table class="schema-admin-table">
          <caption>image ( required )</caption>
          <tr>
            <th>@type :</th>
            <td><small>"ImageObject"</small></td>
          </tr>
          <tr>
            <th>url :</th>
            <td>
              <label for="upload_image">
                <input type="text" name="schema_article_image" id="logo" class="regular-text" required value="<?php echo $schema_article_image; ?>" />
                <small>Default: thumbnail(Featured Image)<br />When Featured image is not available then this image would be shown in the markup</small>
              </label>
            </td>
          </tr>
          <tr>
            <th>height :</th>
            <td><small>Auto : The height of the image, in pixels.</small></td>
          </tr>
          <tr>
            <th>width :</th>
            <td><small>Auto : The width of the image, in pixels. Images should be at least 696 pixels wide.</small></td>
          </tr>
        </table>
        
        <table class="schema-admin-table">
          <caption>publisher( required )</caption>
          <tr>
            <th>@type :</th>
            <td><small>"Organization"</small></td>
          </tr>
          <tr>
            <th><label for="name">Organization Name :</label></th>
            <td><input type="text" name="schema_article_org_name" id="name" class="regular-text" required value="<?php echo $schema_name; ?>" /><small>Default : bloginfo("name")</small></td>
          </tr>
        </table>
        
        <table class="schema-admin-table">
          <caption>logo ( required )</caption>
          <tr>
            <th>@type :</th>
            <td><small>"ImageObject"</small></td>
          </tr>
          <tr>
            <th><label for="logo">url :</label></th>
            <td><input type="text" name="schema_article_logo" id="logo" class="regular-text" required value="<?php echo $schema_article_logo; ?>" /></td>
          </tr>
          <tr>
            <th>height :</th>
            <td><small>Auto : height >= 60px.</small></td>
          </tr>
          <tr>
            <th>width :</th>
            <td><small>Auto : width <= 600px.</small></td>
          </tr>
        </table>

        <table class="schema-admin-table">
          <tbody>
            <tr>
              <td><input type="checkbox" name="schema_article_activate" value="on" <?php echo $schema_activated_checked; ?> /><strong>Activate SCHEMA.ORG Article</strong></td>
            </tr>
          </tbody>
        </table>

        <p>Setting Knowledge : <a href="https://developers.google.com/structured-data/rich-snippets/articles" target="_blank">https://developers.google.com/structured-data/rich-snippets/articles</a></p> 
        <?php submit_button(); ?>
      </form>
    </div>
    <?php
  }
}
