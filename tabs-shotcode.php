<?php
/*
Plugin Name: Tabs Shortcode
Plugin URI: #TODO
Description: Create shortcode that enables you to create tabs 
Author: OLT 
Version: 0.5
Author URI: http://www.olt.ubc.ca
*/
global $olt_tab_shortcode_count;
$olt_tab_shortcode_count = 0;
function olt_display_shortcode_tab($atts,$content)
{
	global $olt_tab_shortcode_count;
	extract(shortcode_atts(array(
		'title' => null,
		'class' => null,
	), $atts));
	
	ob_start();
	if($title):
		?>
		<div id="<?php echo trim(str_replace(" ", "-", $title))."-".$olt_tab_shortcode_count; ?>" >
			<?php echo do_shortcode( $content ); ?>
		</div>
		<? 
	else:
	?>
		<span style="color:red">Please enter a title attribite like [tab title="title name"]tab content[tab]</span>
		<?php 	
	endif;
	$olt_tab_shortcode_count++;
	return ob_get_clean();
}

function olt_display_shortcode_tabs($attr,$content)
{	
	// wordpress function 
	$pattern = get_shortcode_regex();
	
	

	// there might be a better way of doing this
	$id = "random-tab-id-".rand(0,1000);
	
	
	ob_start();
	?>
	<div id='<?php echo $id ?>' class='tabs-shortcode'>
		<ul>
			<?php
				 $tabs = preg_match_all('/'.$pattern.'/s', $content,$matches);
				 $count = 0;
				 $tab_count = 0;
				foreach($matches[2] as $tag):
					if($tag == "tab"):
						
						$attr = shortcode_parse_atts($matches[3][$count]);
						
						if($attr['title']):
						?><li><a href="#<?php echo trim(str_replace(" ", "-", $attr['title']))."-".$tab_count; ?>"><?php echo $attr['title']; ?></a></li>
						<?php
						endif;
						 $tab_count++;
					endif;
					$count++;
				endforeach;
				
			?>
		</ul>
		
		<?php echo do_shortcode( $content ); ?> 
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#<?php echo $id ?>").tabs();
	});
	</script>

	<?php
	return ob_get_clean();
}


function olt_tabs_shortcode_init() {
    
    add_shortcode('tab', 'olt_display_shortcode_tab'); // Individual tab
    add_shortcode('tabs', 'olt_display_shortcode_tabs'); // The shell
       
    // Move wpautop to priority 12 (after do_shortcode)
    //remove_filter('the_content','wpautop',10);
    //add_filter('the_content','wpautop',12);
    
    // add javascript if it is not there yet
     wp_enqueue_script('jquery');
     wp_enqueue_script('jquery-ui-core');
     wp_enqueue_script('jquery-ui-tabs');
	
	// pick up styles from the theme or if you have section widget enbles then you are also set. 
	
}

add_action('init','olt_tabs_shortcode_init');