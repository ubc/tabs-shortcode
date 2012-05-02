<?php
/*
Plugin Name: Tabs Shortcode
Plugin URI: http://wordpress.org/extend/plugins/tabs-shortcode/
Description: Create shortcode that enables you to create tabs on your pages and posts
Author: CTLT
Version: 1.0.2
Author URI: http://ctlt.ubc.ca
*/
global $olt_tab_shortcode_count, $olt_tab_shortcode_tabs;
$olt_tab_shortcode_count = 0;
function olt_display_shortcode_tab($atts,$content)
{
	global $olt_tab_shortcode_count, $post, $olt_tab_shortcode_tabs;
	extract(shortcode_atts(array(
		'title' => null,
		'class' => null,
	), $atts));
		
	ob_start();
	
	if($title):
		$olt_tab_shortcode_tabs[] = array( 
			"title" => $title, 
			"id" => ereg_replace("[^A-Za-z0-9]", "", $title)."-".$olt_tab_shortcode_count,
			"class" => $class
		 );
		?><div id="<?php echo ereg_replace("[^A-Za-z0-9]", "", $title)."-".$olt_tab_shortcode_count; ?>" >
			<?php echo do_shortcode( $content ); ?>
		</div><?php
	elseif($post->post_title):
		$olt_tab_shortcode_tabs[] = array( 
			"title" => $post->post_title, 
			"id" => ereg_replace("[^A-Za-z0-9]", "", $post->post_title)."-".$olt_tab_shortcode_count,
			"class" =>$class
		 );
		?><div id="<?php echo ereg_replace("[^A-Za-z0-9]", "", $post->post_title)."-".$olt_tab_shortcode_count; ?>" >
			<?php echo do_shortcode( $content ); ?>
		</div><?php
	else:
		?>
		<span style="color:red">Please enter a title attribute like [tab title="title name"]tab content[tab]</span>
		<?php 	
	endif;
	$olt_tab_shortcode_count++;
	return ob_get_clean();
}

function olt_display_shortcode_tabs( $attr, $content )
{
	// wordpress function 
	
	global $olt_tab_shortcode_count,$post, $olt_tab_shortcode_tabs;
	$vertical_tabs = "";
	if( isset( $attr['vertical_tabs']) ):
		$vertical_tabs = ( (bool)$attr['vertical_tabs'] ? "vertical-tabs": "");
		unset($attr['vertical_tabs']);
	endif;
	
	// $attr['disabled'] =     (bool)$attr['disabled'];
	$attr['collapsible'] =  (bool)$attr['collapsible'];
	$query_atts = shortcode_atts(
		array( 
			'collapsible'	=> false,
			'event'			=>'click',
		), $attr);
	// there might be a better way of doing this
	$id = "random-tab-id-".rand(0,1000);
	
	ob_start();
	?>
	<div id="<?php echo $id ?>" class="tabs-shortcode <?php echo $vertical_tabs; ?>"><?php
		
			$content = (substr($content,0,6) =="<br />" ? substr( $content,6 ): $content);
			$content = str_replace("]<br />","]",$content);
			
			$str = do_shortcode( $content ); ?>
			<ul>
			<?php
			foreach( $olt_tab_shortcode_tabs as $li_tab ): 
			
			?><li <?php if( $li_tab['class']): ?> class='<?php echo $li_tab['class'];?>' <?php endif; ?> ><a href="#<?php echo $li_tab['id']; ?>"><?php echo $li_tab['title']; ?></a></li><?php 
			endforeach;
			
			
				
			?></ul><?php echo $str; ?></div>
	<script type="text/javascript"> /* <![CDATA[ */ 
	jQuery(document).ready(function($) { $("#<?php echo $id ?>").tabs(<?php echo json_encode($query_atts); ?> ); }); 
	/* ]]> */
	</script>

	<?php
	$post_content = ob_get_clean();
	
	 wp_enqueue_script('jquery');
     wp_enqueue_script('jquery-ui-core');
     wp_enqueue_script('jquery-ui-tabs');
	return str_replace("\r\n", '',$post_content);
}


function olt_tabs_shortcode_init() {
    
    add_shortcode('tab', 'olt_display_shortcode_tab'); // Individual tab
    add_shortcode('tabs', 'olt_display_shortcode_tabs'); // The shell
       
    // Move wpautop to priority 12 (after do_shortcode)
    /* 
     remove_filter('the_content','wpautop', 10);
     add_filter('the_content','wpautop', 12);
    */
}

add_action('init','olt_tabs_shortcode_init');