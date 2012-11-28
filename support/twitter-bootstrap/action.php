<?php 






/**
 * tabs_shortcode_twitter_content_shell function.
 * 
 * @access public
 * @param mixed $content_shell
 * @return void
 */
function tabs_shortcode_twitter_content_shell( $content_shell ) {
	return  '<div class="tab-content">'.$content_shell.'</div>';
}
add_filter( 'tabs-shortcode-content-shell', 'tabs_shortcode_twitter_content_shell' );


/**
 * tabs_shortcode_twitter_shell_class function.
 * 
 * @access public
 * @param mixed $shell_class
 * @return void
 */
function tabs_shortcode_twitter_shell_class( $shell_class, $position ) {
	$postion_class = '';
	switch($position){
		case 'bottom':
			$postion_class =" tabs-below";
		break;
		case 'left':
			$postion_class =" tabs-left";
		break;
		
		case 'right':
			$postion_class =" tabs-right";
		break;
		
		
	
	}
	return "tabbable".$postion_class;
}
add_filter( 'tabs-shortcode-shell-class', 'tabs_shortcode_twitter_shell_class', 10, 2 );


/**
 * tabs_shortcode_twitter_list_shell function.
 * 
 * @access public
 * @param mixed $list_class
 * @return void
 */
function tabs_shortcode_twitter_list_shell( $list_class ) {
	return "nav nav-tabs";
}
add_filter( 'tabs-shortcode-list-class', 'tabs_shortcode_twitter_list_shell' );


/**
 * tabs_shortcode_twitter_list_attr function.
 * 
 * @access public
 * @param mixed $list_attr
 * @return void
 */
function tabs_shortcode_twitter_list_link_attr( $list_attr ) {
	return 'data-toggle="tab"'; 
}
add_filter( 'tabs-shortcode-list-link-attr', 'tabs_shortcode_twitter_list_link_attr' );


/**
 * tabs_shortcode_twitter_content_panel_class function.
 * 
 * @access public
 * @param mixed $panel_class
 * @return void
 */
function tabs_shortcode_twitter_content_panel_class( $panel_class, $selected ) {
		$active = ($selected ? ' active ': '' );
	return "tab-pane".$active; 
}
add_filter( 'tabs-shortcode-content-panel-class', 'tabs_shortcode_twitter_content_panel_class', 10, 3 );
