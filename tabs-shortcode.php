<?php
/*
Plugin Name: Tabs Shortcode
Plugin URI: http://wordpress.org/extend/plugins/tabs-shortcode/
Description: Create shortcode that enables you to create tabs on your pages and posts
Author: CTLT
Version: 1.1.1

Author URI: http://ctlt.ubc.ca
*/

/**
 * OLT_Tab_Shortcode class.
 */
class OLT_Tab_Shortcode {
	
	static $add_script;
	static $shortcode_count;
	static $shortcode_data;
	static $shortcode_js_data;
	static $current_tab_id;
	
	/**
	 * init function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	static function init() {

		add_shortcode('tab', array(__CLASS__, 'tab_shortcode'));
		add_shortcode('tabs', array(__CLASS__, 'tabs_shortcode'));

		add_action('init', array(__CLASS__, 'register_script'));
		add_action('wp_footer', array(__CLASS__, 'print_script'));
		
		self::$shortcode_count = 0;

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
		$class_atr  = ( empty( $class ) ? '' : 'class=" '.$class.' "' );
		$title 		= ( empty( $title ) ? $post->post_title : $title );
		$id 		= ereg_replace("[^A-Za-z0-9]", "", $title )."-".self::$shortcode_count;
		
		if( empty( $title ) )
			return '<span style="color:red">Please enter a title attribute like [tab title="title name"]tab content[tab]</span>';
		
		self::$shortcode_data[  self::$current_tab_id ][] = array( 'title' => $title, 'id' => $id , 'class' => $class );
		
		self::$shortcode_count++;

		return '<div id="'.$id.'" '.$class_atr.' >'. do_shortcode( $content ). '</div>';
		
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
		
		self::$add_script = true;

		if( is_string($atts) )
			$atts = array();
			
		if( isset( $atts['vertical_tabs']) ):
			$vertical_tabs = ( self::eval_bool( $atts['vertical_tabs'] ) ? "vertical-tabs": "");
			unset($atts['vertical_tabs']);
		endif;
			
		// optional attributes
		$attr['collapsible'] =  self::eval_bool( $atts['collapsible'] );
		$attr['selected']  	=   (int)$atts['selected'];
		
		
		$query_atts = shortcode_atts( array(
				'collapsible'	=> false,
				'selected' 		=> 0,
				'event'   		=> 'click',
			), $attr );
		
		self::$current_tab_id = "random-tab-id-".rand(0,1000);
		
		$content = str_replace( "]<br />","]", ( substr( $content, 0 , 6 ) == "<br />" ? substr( $content, 6 ): $content ) );

		self::$shortcode_js_data[ self::$current_tab_id ] = $query_atts;
		
		$individual_tabs = do_shortcode( $content );
		
		ob_start();
		?>
		<div id="<?php echo self::$current_tab_id ?>" class="tabs-shortcode <?php echo $vertical_tabs; ?>"><?php
		
			$content = (substr($content,0,6) =="<br />" ? substr( $content,6 ): $content);
			$content = str_replace("]<br />","]",$content); ?>
			<ul>
			<?php
			foreach( self::$shortcode_data[self::$current_tab_id] as $tab_data ): ?>
				<li <?php if( $tab_data['class']): ?> class='<?php echo $tab_data['class'];?>' <?php endif; ?> ><a href="#<?php echo $tab_data['id']; ?>"><?php echo $tab_data['title']; ?></a></li><?php 
			endforeach;
			
			?></ul><?php 
			// display the 
			echo $individual_tabs; ?></div><?php
					
		return str_replace("\r\n", '', ob_get_clean() );

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
	static function register_script() {
		wp_register_script( 'tab-shortcode' , plugins_url('tab.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), '1.0', true );
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
		
		wp_enqueue_script( 'tab-shortcode' );
		wp_localize_script( 'tab-shortcode', 'tabs_shortcode', self::$shortcode_js_data );
		wp_enqueue_script('jquery');
    	wp_enqueue_script('jquery-ui-core');
    	wp_enqueue_script('jquery-ui-tabs');
	}
}
// lets play
OLT_Tab_Shortcode::init();

