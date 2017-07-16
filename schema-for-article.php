<?php 

/**
 * Plugin Name: Schema for Article
 * Plugin URI: https://wordpress.org/plugins/schema-for-article/
 * Description: Schema for Article is simply the easiest solution to add valid schema.org as a JSON script in the head of blog posts or posts. The provided LD-JSON is validated from the google structured data.
 * Version: 0.2
 * Donate link: https://www.paypal.me/yasglobal
 * Author: Sami Ahmed Siddiqui
 * Author URI: http://www.yasglobal.com/web-design-development/wordpress/schema-article/
 * License: GPL v3
 */

/**
 *  Schema for Article Plugin
 *  Copyright (C) 2016, Sami Ahmed Siddiqui <sami@samisiddiqui.com>
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
function schema_article_settings_link($links) { 
   $settings_link = '<a href="admin.php?page=schema-article-settings">Settings</a>'; 
   array_unshift($links, $settings_link); 
   return $links; 
}

function schema_article_menu() {
	add_menu_page('SCHEMA.ORG ARTICLE SETTINGS', 'SCHEMA.ORG ARTICLE Settings', 'administrator', 'schema-article-settings', 'schema_article_settings_page');
   add_action( 'admin_init', 'register_schema_article_settings' );
}

function register_schema_article_settings() {
   register_setting( 'schema-article-settings-group', 'schema_article_type' );
   register_setting( 'schema-article-settings-group', 'schema_article_org_name' );
   register_setting( 'schema-article-settings-group', 'schema_article_logo' );
   register_setting( 'schema-article-settings-group', 'schema_article_image' );
   register_setting( 'schema-article-settings-group', 'schema_article_activate' );
}

function schema_article_styles() {
   wp_register_style( 'style', plugins_url('/style.css', __FILE__) );
   wp_enqueue_style( 'style' );
}

function schema_article_settings_page() {
	if ( !current_user_can( 'administrator' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
   echo '<div class="wrap">';
   echo '<h2>SCHEMA.ORG ARTICLE SETTINGS</h2>';
   echo '<div>Define the Permalinks for each post type. You can define different structures for each post type. </div>';
   echo '<form method="post" action="options.php">';
   settings_fields( 'schema-article-settings-group' );
   do_settings_sections( 'schema-article-settings-group' );
   $schema_article_type = esc_attr( get_option('schema_article_type') );
   $schema_name = esc_attr( get_option('schema_article_org_name') );
   $schema_activated = esc_attr( get_option('schema_article_activate') );
   $schema_activated_checked = "";
   if(empty($schema_name)){
      $schema_name = get_bloginfo("name");
   }
   if($schema_activated == 'on'){
      $schema_activated_checked = "checked";
   }
   ?>
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
         <td><small>Default : get_the_time( DATE_ISO8601, ID )</small></td></tr>
	   <tr>
         <th>dateModified :</th>
         <td><small>Default : get_the_modified_time( DATE_ISO8601, false, ID )</small></td></tr>
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
         <td><small>"ImageObject"</small></td></tr>
		<tr>
         <th>url :</th>
         <td>
            <label for="upload_image">
               <input type="text" name="schema_article_image" id="logo" class="regular-text" required value="<?php echo esc_attr( get_option('schema_article_image') ); ?>" />
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
		<tr><th>@type :</th><td><small>"ImageObject"</small></td></tr>
		<tr>
         <th><label for="logo">url :</label></th>
         <td><input type="text" name="schema_article_logo" id="logo" class="regular-text" required value="<?php echo esc_attr( get_option('schema_article_logo') ); ?>" /></td>
      </tr>
		<tr>
         <th>height :</th>
         <td><small>Auto : height >= 60px.</small></td>
      </tr>
		<tr><th>width :</th><td><small>Auto : width <= 600px.</small></td></tr>
	</table>

		<table class="schema-admin-table">
         <tbody>
            <tr>
               <td><input type="checkbox" name="schema_article_activate" value="on" <?php echo $schema_activated_checked; ?> /><strong>Activate SCHEMA.ORG Article</strong></td>
            </tr>
         </tbody>
      </table>

		<p>Setting Knowledge : <a href="https://developers.google.com/structured-data/rich-snippets/articles" target="_blank">https://developers.google.com/structured-data/rich-snippets/articles</a></p> 
   <?php
   submit_button(); 
   echo '</form>';
   echo '</div>';
}

function schema_article_add_json_markup(){
	global $post;
   if ( esc_attr( get_option('schema_article_activate') ) == "on" ) {
      $schema_name = esc_attr( get_option('schema_article_org_name') );
      $schema_article_type = esc_attr( get_option('schema_article_type') );
      $schema_logo = esc_attr( get_option('schema_article_logo') );
      $schema_image = esc_attr( get_option('schema_article_image') );
		$images = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		if( isset($images) && empty($images)){
         $images[0] = $schema_image;
      }
      if( $schema_article_type == "" ){
         $schema_article_type = "Article";
      }
		$excerpt = schema_article_escape_text_tags($post->post_excerpt);
		$content = $excerpt === "" ? mb_substr( schema_article_escape_text_tags( $post->post_content ), 0, 110 ) : $excerpt;
		$args = array(
				"@context" => "http://schema.org",
				"@type"    => $schema_article_type,
				"mainEntityOfPage" => array(
					"@type" => "WebPage",
					"@id"   => get_permalink( $post->ID )
				),
				"headline" => schema_article_escape_text_tags( $post->post_title ),
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
					"name"  => schema_article_escape_text_tags( get_the_author_meta( 'display_name', $post->post_author ) )
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
		schema_article_set_schema_json( $args );
	}
}

function schema_article_escape_text_tags ( $text ) {
	return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}

function schema_article_set_schema_json ( array $args ) {
	echo '<script type="application/ld+json">' , PHP_EOL;
	echo json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
	echo '</script>' , PHP_EOL;
}

if(function_exists("add_action") && function_exists("add_filter")) { 
   $plugin = plugin_basename(__FILE__); 
   add_filter("plugin_action_links_$plugin", 'schema_article_settings_link' );
   
   add_action( 'admin_menu', 'schema_article_menu' );
   add_action ('wp_head','schema_article_add_json_markup');  
}

if (isset($_GET['page']) && $_GET['page'] == 'schema-article-settings') {
   add_action('admin_print_styles', 'schema_article_styles');
}
