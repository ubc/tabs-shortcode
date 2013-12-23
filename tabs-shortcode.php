<?php
/**
* Plugin Name: Tabs Shortcode
* Plugin URI: http://wordpress.org/extend/plugins/tabs-shortcode/
* Description: Create shortcode that enables you to create tabs on your pages and posts
* Author: CTLT
* Version: 2.0.2
* Author URI: http://ctlt.ubc.ca

* This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
* General Public License as published by the Free Software Foundation; either version 2 of the License, 
* or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
* even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* You should have received a copy of the GNU General Public License along with this program; if not, write 
* to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
* General Public License as published by the Free Software Foundation; either version 2 of the License, 
* or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
* even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* You should have received a copy of the GNU General Public License along with this program; if not, write 
* to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

/**
 * OLT_Tab_Shortcode class.
 */
class OLT_Tab_Shortcode {
	
	static $add_script;
	static $shortcode_count;
	static $current_active_content;
	static $shortcode_data;
	static $shortcode_js_data;
	static $current_tab_id;
	
	static $tabs_support;
	
	
	/**
	* has_shortcode function.
	*
	* @access public
	* @param mixed $shortcode
	* @return void
	*/
	function has_shortcode( $shortcode ) {
		global $shortcode_tags;
	
		return ( in_array( $shortcode, array_keys ( $shortcode_tags ) ) ? true : false);
	}

	/**
	* add_shortcode function.
	*
	* @access public
	* @param mixed $shortcode
	* @param mixed $shortcode_function
	* @return void
	*/
	function add_shortcode( $shortcode, $shortcode_function ) {
	
	if( !self::has_shortcode( $shortcode ) )
		add_shortcode( $shortcode, array( __CLASS__, $shortcode_function ) );
	}
	/**
	 * init function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	static function init() {

		self::add_shortcode( 'tab', 'tab_shortcode' );
		self::add_shortcode( 'tabs', 'tabs_shortcode' );
		

		add_action( 'init', array(__CLASS__, 'register_script_and_style' ) );
		add_action( 'wp_footer', array(__CLASS__, 'print_script' ) );
		
		add_action( 'wp_enqueue_scripts', array(__CLASS__, 'enqueue_style' ) );
		
		/* Apply filters to the tabs content. */
		add_filter( 'tab_content', 'wpautop' );
		add_filter( 'tab_content', 'shortcode_unautop' );
		add_filter( 'tab_content', 'do_shortcode' );
		
		self::$shortcode_count = 0;
		self::$current_active_content = 0;
		

	}
	
	/**
	 * tab_shortcode function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $atts
	 * @param mixed $content
	 * @return void
	 */
	public static  function tab_shortcode( $atts, $content ) {
		global $post;
		
		extract(shortcode_atts(array(
					'title' => null,
					'class' => null,
				), $atts) );
		
		// 
		$selected = ( self::$current_active_content == self::$shortcode_count ? true : false );
		
		$class = apply_filters( "tabs-shortcode-content-panel-class", $class, $selected );
		$class_atr  = ( empty( $class ) ? '' : 'class=" '.$class.' "' );
		$title 		= ( empty( $title ) ? $post->post_title : $title );
		$id 		= preg_replace("/[^A-Za-z0-9]/", "", $title )."-".self::$shortcode_count;
		
		
		if( empty( $title ) )
			return '<span style="color:red">Please enter a title attribute like [tab title="title name"]tab content[tab]</span>';
		
		self::$shortcode_data[  self::$current_tab_id ][] = array( 'title' => $title, 'id' => $id , 'class' => $class );
		
		self::$shortcode_count++;

		return '<div id="'.$id.'" '.$class_atr.' >'. apply_filters( 'tab_content', $content ). '</div>';
		
	}
	
	
	/**
	 * tabs_shortcode function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $atts
	 * @param mixed $content
	 * @return void
	 */
	public static function tabs_shortcode( $atts, $content ) {
		
		self::$add_script =  true;

		if( is_string($atts) )
			$atts = array();
		
		if( isset( $atts['vertical_tabs'] ) ):
			$vertical_tabs = ( self::eval_bool( $atts['vertical_tabs'] ) ? "vertical-tabs": "");
			unset($atts['vertical_tabs']);
		else:
			$vertical_tabs = "";
		endif;
		
		if( isset( $atts['position'] )  && in_array( $atts['position'], array( 'top', 'bottom', 'left', 'right' ) ) ):
			$position = $atts['position'];
		else:
			$position = ( empty($vertical_tabs) ? 'top' : 'left');
		endif;
		
		// optional attributes
		
		$attr['collapsible'] =  ( isset($atts['collapsible']) ? self::eval_bool( $atts['collapsible'] ) : false );
		$attr['selected']  	=   ( isset($atts['selected']) ? (int)$atts['selected'] : 0);
		$attr['event']  	=   ( isset($atts['event']) && in_array($atts['event'], array('click', 'mouseover') ) ? $atts['event'] : 'click');
		
		self::$current_active_content = $attr['selected'] + self::$shortcode_count;
		
		$query_atts = shortcode_atts( array(
				'collapsible'	=> false,
				'selected' 		=> 0,
				'event'   		=> 'click',
			), $attr );
		
		self::$current_tab_id = "random-tab-id-".rand(0,1000);
		
		$content = str_replace( "]<br />","]", ( substr( $content, 0 , 6 ) == "<br />" ? substr( $content, 6 ): $content ) );
		
		self::$shortcode_js_data[ self::$current_tab_id ] = $query_atts;
		
		$individual_tabs = do_shortcode( $content );
		$individual_tabs = apply_filters( 'tabs-shortcode-content-shell', $individual_tabs );
		
		$shell_class = apply_filters( 'tabs-shortcode-shell-class', "tabs-shortcode ". $vertical_tabs." tabs-shortcode-".$position, $position );
		$list_class  = apply_filters( 'tabs-shortcode-list-class', "tabs-shortcode-list" );
		
		$list_attr   = apply_filters( 'tabs-shortcode-list-attr', ''); // don't 
		$list_link_attr   = apply_filters( 'tabs-shortcode-list-link-attr', ''); // don't 
		ob_start();
		
		?><div id="<?php echo self::$current_tab_id ?>" class="<?php echo $shell_class ?>"><?php
		
			if( $position == 'bottom' )
				echo $individual_tabs;
		
			// $content = (substr($content,0,6) =="<br />" ? substr( $content,6 ): $content);
			// $content = str_replace("]<br />","]",$content); ?>
			<ul class="<?php echo $list_class ?>">
			<?php
			$list_counter_class = 0;
			foreach( self::$shortcode_data[self::$current_tab_id] as $tab_data ): ?>
				<li <?php if( $tab_data['class']): ?> class="<?php echo $tab_data['class'];?>  " <?php echo $list_attr; ?> <?php endif; ?> ><a href="#<?php echo $tab_data['id']; ?>" <?php echo $list_link_attr; ?>><?php echo $tab_data['title']; ?></a></li><?php 
			$list_counter_class++;
			endforeach;
			
			?></ul><?php 
			
			
			if( $position != 'bottom' )
				echo $individual_tabs;
			
			?></div><?php
					
		return apply_filters( 'tab_content', str_replace("\r\n", '',  ob_get_clean() ) );

	}
	
	/**
	 * eval_bool function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $item
	 * @return void
	 */
	static function eval_bool( $item ) {
		
		return ( (string) $item == 'false' || (string)$item == 'null'  || (string)$item == '0' || empty($item)   ? false : true );
	}
	
	/**
	 * register_script function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	static function register_script_and_style() {
		self::$tabs_support = get_theme_support('tabs');
		
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		
		wp_register_style( 'tab-shortcode',  plugins_url('tab'.$suffix.'.css', __FILE__) );
		wp_register_script( 'tab-shortcode' , plugins_url('tab'.$suffix.'.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), '1.0', true );
		
		if( self::$tabs_support[0] == 'twitter-bootstrap' ):
			require_once( 'support/twitter-bootstrap/action.php' );
			
			wp_register_script( 'twitter-tab-shortcode' , plugins_url('support/twitter-bootstrap/twitter.bootstrap.tabs'.$suffix.'.js', __FILE__), array( 'jquery' ), '1.0', true );
		
		endif;
		
		
	}
	
	static function enqueue_style() {
		if( empty( self::$tabs_support ) )
			wp_enqueue_style( 'tab-shortcode' );
		
	}
	
	/**
	 * print_script function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	static function print_script() {
		
		if ( ! self::$add_script )
			return;
		
		
		if( empty( self::$tabs_support ) ||  'style-only' == self::$tabs_support[0]) {
			wp_enqueue_script( 'tab-shortcode' );
			wp_localize_script( 'tab-shortcode', 'tabs_shortcode', self::$shortcode_js_data );
    	}
    	
    	if( self::$tabs_support[0] == 'twitter-bootstrap' ) {
    		
    		wp_enqueue_script( 'twitter-tab-shortcode' );
			
    	}
	}
}
// lets play
OLT_Tab_Shortcode::init();

