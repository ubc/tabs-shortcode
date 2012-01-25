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
	global $olt_tab_shortcode_count,$post;
	extract(shortcode_atts(array(
		'title' => null,
		'class' => null,
	), $atts));
	
	ob_start();
	
	if($title):
		?>
		<div id="<?php echo ereg_replace("[^A-Za-z0-9]", "", $title)."-".$olt_tab_shortcode_count; ?>" >
			<?php echo do_shortcode( $content ); ?>
		</div>
		<?php
	elseif($post->post_title):
	?>
		<div id="<?php echo ereg_replace("[^A-Za-z0-9]", "", $post->post_title)."-".$olt_tab_shortcode_count; ?>" >
			<?php echo do_shortcode( $content ); ?>
		</div>
	<?php
	else:
	?>
		<span style="color:red">Please enter a title attribute like [tab title="title name"]tab content[tab]</span>
		<?php 	
	endif;
	$olt_tab_shortcode_count++;
	return ob_get_clean();
}

function olt_display_shortcode_tabs($attr,$content)
{
	// wordpress function 
	$pattern = get_shortcode_regex();
	global $olt_tab_shortcode_count,$post;
	

	// there might be a better way of doing this
	$id = "random-tab-id-".rand(0,1000);
	
	
	ob_start();
	?>
	<div id='<?php echo $id ?>' class='tabs-shortcode'>
		<ul>
			<?php
				 $tabs = preg_match_all('/'.$pattern.'/s', $content,$matches);
				 $count = 0;
				 $tab_count = $olt_tab_shortcode_count;
				foreach($matches[2] as $tag):
					if($tag == "tab"):
						
						$attr = shortcode_parse_atts($matches[3][$count]);
						
						if( $attr['title'] ):
						?><li <?php if( $attr['class']): ?> class='<?php echo $attr['class'];?>' <?php endif; ?>
							><a href="#<?php echo ereg_replace("[^A-Za-z0-9]", "", $attr['title'])."-".$tab_count; ?>"><?php echo $attr['title']; ?></a></li>
						<?php
						elseif( $post->post_title ):
							?><li <?php if( $attr['class']): ?> class='<?php echo $attr['class'];?>' <?php endif; ?>
							><a href="#<?php echo ereg_replace("[^A-Za-z0-9]", "", $post->post_title)."-".$tab_count; ?>"><?php echo $post->post_title; ?></a></li><?php
						
						endif;
						 $tab_count++;
					endif;
					$count++;
				endforeach;
				
			?></ul><?php 
		echo do_shortcode( $content ); ?> 
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#<?php echo $id ?>").tabs();
	});
	</script>

	<?php
	$post_content = ob_get_clean();
	// var_dump($content, str_replace("\r\n", '',$content));
	 wp_enqueue_script('jquery');
     wp_enqueue_script('jquery-ui-core');
     wp_enqueue_script('jquery-ui-tabs');
	return str_replace("\r\n", '',$post_content);
}


function olt_tabs_shortcode_init() {
    
    add_shortcode('tab', 'olt_display_shortcode_tab'); // Individual tab
    add_shortcode('tabs', 'olt_display_shortcode_tabs'); // The shell
       
    // Move wpautop to priority 12 (after do_shortcode)
    remove_filter('the_content','wpautop', 10);
    add_filter('the_content','wpautop', 12);
    
    // add javascript if it is not there yet
    
	
	// pick up styles from the theme or if you have section widget enbles then you are also set. 
	
}

add_action('init','olt_tabs_shortcode_init');