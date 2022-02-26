<?php
/**
 * Functions which allow to set options for theme
 *
 * @package eve
 */

// TODO
// - Include gmap api key field in the settings page
// - Include base color settings

 
/**
 * Registers a text field setting for Wordpress 4.7 and higher.
 */
function eve_general_section() 
{  
  $section_id = 'progresseve';
  $page_name = 'general';

  add_settings_section(  
      $section_id, 
      'Progresseve settings', // Section Title
      'progresseve_section_options_callback', // Callback
      $page_name // What Page?  This makes the section show up on the General Settings Page
  );

  add_settings_field( // Option 1
      'eve_gtm_code', // Option ID
      'GTM Code', // Label
      'my_textbox_callback', // !important - This is where the args go!
      $page_name, // Page it will be displayed (General Settings)
      $section_id, // Name of our section
      array( // The $args
          'eve_gtm_code' // Should match Option ID
      )  
  );

  add_settings_field(
      'eve_environment_details',
      'Environment',
      'eve_env_dd_callback',
      $page_name,
      $section_id,
      array(
        'eve_environment_details'
      )  
  );

  add_settings_field(
      'eve_theme_version',
      'Version',
      'my_textbox_callback',
      $page_name,
      $section_id,
      array(
          'eve_theme_version'
      )  
  ); 

  add_settings_field(
    'eve_html_compression',
    'HTML Compression',
    'eve_htmlgen_dd_callback',
    $page_name,
    $section_id,
    array(
        'eve_html_compression'
    )  
  );

  register_setting( $page_name, 'eve_gtm_code', 'esc_attr' );
  register_setting( $page_name, 'eve_environment_details', 'esc_attr' );
  register_setting( $page_name, 'eve_theme_version', 'esc_attr' );
  register_setting( $page_name, 'eve_html_compression', 'esc_attr' );
}

function progresseve_section_options_callback()
{
  echo '<p>General theme settings</p>';  
}

function my_textbox_callback($args)
{
  $option = get_option($args[0]);
  echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

function eve_env_dd_callback($args)
{
	$options = get_option($args[0]);
	$items = array(
    0 => 'Development',
    1 => 'Live'
  );
	echo '<select id="'. $args[0] .'" name="'. $args[0]. '">';
	foreach($items as $k => $v) {
		$selected = ($options[0]==$k) ? ' selected="selected"' : '';
    echo '<option value="'. $k .'"'. $selected .'>'. $v .'</option>';
	}
	echo "</select>";
}

function  eve_htmlgen_dd_callback($args)
{
	$options = get_option($args[0]);
	$items = array(
    0 => 'No',
    1 => 'Yes'
  );
	echo '<select id="'. $args[0] .'" name="'. $args[0]. '">';
	foreach($items as $k => $v) {
		$selected = ($options[0]==$k) ? ' selected="selected"' : '';
    echo '<option value="'. $k .'"'. $selected .'>'. $v .'</option>';
	}
	echo "</select>";
}