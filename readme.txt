=== Tabs Shortcode ===
Contributors: enej, ctlt-dev, oltdev
Tags: tab, shortcode
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 2.0.2
License: GPLv2 or later

Lets you add tabs to your post and pages using a shortcode. 

== Description ==

To add tabs to you post or pages just add this shortcode:

`[tabs]
[tab title="title1"] tab content 
tab content 
[/tab]
[tab title="title2"] 
another content tab 
[/tab]
[/tabs]`


Here are the some attributes that the shortcode also excepts 
// default attributes
`[tabs collapsible=true selected='0' event='click' position='top' ]  
[tab title="title1"]
tab content 
[/tab]
[tab title="title2"] 
another content tab 
[/tab]
[/tabs]`

* collapsible = true or false - weather the tabs should be allowed to be collapsed - this doesn't work with twitter bootstrap 
* selected = integer for example - what tab should be selected. 0 means the first tab. 1 means the second tab etc. 
* event = 'click' or 'mouseover' - does do you user need to click on the tab or just mouse over to get to the content. Tip: Don't use mouseover if you are concerned with mobile. 
* position = 'top' , 'bottom' , 'left', 'right' on what side do you want the tabs to appear. See screenshots for an example. 
* vertical_tabs = true or false - depreciated is the same as position = left


== Installation ==
See http://codex.wordpress.org/Managing_Plugins#Installing_Plugins

== Upgrade Notice ==
If you are updating from the proviso version and you have added css to your theme 
Please add `add_theme_support( 'tabs', 'style-only' );` to you functions file. Preferably somewhere in a function that is being called by the after theme setup action
 `add_action('after_setup_theme','bones_theme_support');` 

This will tell the plugin to not include tab styling to your theme. 


 
== Frequently Asked Questions ==

=How to get rid of unwanted `<p>` tags=
Get rid of unneeded white space inside your shortcode 


=My theme already has styling for tabs how can I remove the default styling=
Easy. Add the line `add_theme_support( 'tabs', 'style-only' );` to you functions.php file. Preferably somewhere in a function that is being called by the after theme setup action
 `add_action('after_setup_theme','bones_theme_support');` 


=I am using the twitter bootstrap framework how do I make sure that the tabs work with it.=
The shortcode support the twitter bootstrap framework. 
`add_theme_support( 'tabs', 'twitter-bootstrap' );`

= How can I contribute to this plugin =
If you must ask. Checkout the source code at https://github.com/ubc/tabs-shortcode

Feel free to submit pull requests. 


**note**: The twitter bootstrap framework doesn't use the jquery ui tab javascript.

== Screenshots ==

1. Default styling 
2. Styling using the twitter bootstrap 

== Sample CSS ==

Want to style the tabs a different way. 

Here is some sample css to get you started. 
Another place to look for it would be the http://jqueryui.com/themeroller/, 
The shortcode used the jQuery UI to generate the tabs unless you are using the twitter bootstrap framework. 
See the FAQ on how to deal with that case. 





`
/* =tabs
-------------------------------------------------------------- */
.tabs-shortcode.ui-tabs {
	padding:.2em;
	zoom:1;
	clear:both;
	background:#FFF;
	padding:0;
	margin:0;
}

.tabs-shortcode.ui-tabs-nav {
	list-style:none!important;
	padding:.2em 0 0!important;
	margin: 0!important;
}
.tabs-shortcode .ui-tabs-nav:after{
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
}
* html .tabs-shortcode  .ui-tabs-nav          { zoom: 1; } /* IE6 */
*:first-child+html .tabs-shortcode .ui-tabs-nav { zoom: 1; } /* IE7 */

.tabs-shortcode .ui-tabs-nav li {
	position:relative;
	float:left;
	border:1px solid #CCC;
	background:#EEE;
	list-style:none!important;
	z-index: 100;
	padding:0;
}

.tabs-shortcode.ui-tabs .ui-tabs-nav li.ui-tabs-active,
.tabs-shortcode.ui-tabs .ui-tabs-nav li.ui-tabs-selected {
	background:#FFF;
	color:#111;
}

.tabs-shortcode .ui-tabs-nav li:before {
	content:"";
}

.tabs-shortcode .ui-tabs-nav li a {
	float:left;
	text-decoration:none;
	padding:2px 1em;
	color:#333;
	border:none!important;
}

.tabs-shortcode.ui-tabs .ui-tabs-nav li.ui-tabs-active a,
.tabs-shortcode.ui-tabs .ui-tabs-nav li.ui-tabs-selected a,
.tabs-shortcode.ui-tabs .ui-tabs-nav li.ui-state-disabled a,
.tabs-shortcode.ui-tabs .ui-tabs-nav li.ui-state-processing a {
	cursor: default;
}

.tabs-shortcode .ui-tabs-nav li a,
.tabs-shortcode.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-active a,
.tabs-shortcode.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a {
	cursor:pointer;
}

.tabs-shortcode .ui-tabs-panel {
	display:block;
	border-width:0;
	background:none;
}

.tabs-shortcode .ui-tabs-hide {
	display:none!important;
}

.tabs-shortcode.ui-tabs-panel {
	clear:both;
}
/* Position  Top and Bottom  */
.tabs-shortcode-top .ui-tabs-nav,
.tabs-shortcode-bottom .ui-tabs-nav{
	margin-left:0!important;
}
.tabs-shortcode-top .ui-tabs-nav li,
.tabs-shortcode-bottom .ui-tabs-nav li{
	position:relative;
	float:left;
	position:relative;
	float:left;
}

/* Position Top */
.tabs-shortcode-top .ui-tabs-nav{
	border-bottom: 1px solid #CCC;
}
.tabs-shortcode-top .ui-tabs-nav li.ui-tabs-active,
.tabs-shortcode-top .ui-tabs-nav li.ui-tabs-selected {
	padding-bottom:1px!important;
	border-bottom:0;
	margin:1px .3em -1px 0!important;
}
.tabs-shortcode-top .ui-tabs-nav li {
	border-bottom-width:0!important;
	margin:1px .3em 0 0!important;
}

/* Position Bottom */
.tabs-shortcode-bottom .ui-tabs-nav{
	border-top: 1px solid #CCC;
}
.tabs-shortcode-bottom .ui-tabs-nav li.ui-tabs-active,
.tabs-shortcode-bottom .ui-tabs-nav li.ui-tabs-selected {
	padding-top:1px!important;
	border-top:0;
	margin:-1px .3em 1px 0!important;
}

.tabs-shortcode-bottom .ui-tabs-nav li {
	border-top-width:0!important;
	margin:0 .3em 1px 0!important;	
}


/* Position  Left and Right  */
.tabs-shortcode-left .ui-tabs-nav,
.tabs-shortcode-right .ui-tabs-nav{
	width: 150px;
	margin: 0!important;
}

.tabs-shortcode-left .ui-tabs-nav li,
.tabs-shortcode-left,
.tabs-shortcode-right .ui-tabs-nav li,
.tabs-shortcode-right{
	position: relative;
	overflow: hidden;
}
.tabs-shortcode-left .ui-tabs-nav li,
.tabs-shortcode-right .ui-tabs-nav li{
	margin:0 0 0.3em 0;
	width: 100%;
}
.tabs-shortcode-left .ui-tabs-nav li a,
.tabs-shortcode-right .ui-tabs-nav li a{
	width: 100%;
}
.tabs-shortcode-left .ui-tabs-panel,
.tabs-shortcode-right .ui-tabs-panel{
	margin-left: 165px;
}

/* Position Left */
.tabs-shortcode-left .ui-tabs-nav{
	border-right: 1px solid #CCC;
	padding: 0 1px 10px 0!important;
}
.tabs-shortcode-left .ui-tabs-nav,
.tabs-shortcode-left .ui-tabs-nav li{
	float: left;
}
.tabs-shortcode-left .ui-tabs-nav li.ui-tabs-active,
.tabs-shortcode-left .ui-tabs-nav li.ui-tabs-selected {
	padding-right:1px;
	border-right:0;
	margin:0 1px 0.3em 0;
}

/* Position Right */
.tabs-shortcode-right .ui-tabs-nav{
	border-left: 1px solid #CCC;
	padding: 0 0 10px 1px!important;
}
.tabs-shortcode-right .ui-tabs-nav,
.tabs-shortcode-right .ui-tabs-nav li{
	float: right;
}
.tabs-shortcode-right .ui-tabs-nav li.ui-tabs-active,
.tabs-shortcode-right .ui-tabs-nav li.ui-tabs-selected {
	padding-left:1px;
	border-left:0;
	margin:0 0 0.3em 1px;
}
`

== Changelog ==
= 2.0.2 =
* Minified files so that things are load even faster, saving tree though bandwidth.

= 2.0.1 =
* Bug fixes: Removes notices
* updated to styles better with version jQuery 1.9
 
= 2 = 
* Rewrite of the plugin
* Now we are adding some tab styling by default
* Added position attribute (top, bottom, left, right)


= 1.1.1 =
* removing unwanted warnings. 
  
= 1.1 = 
* rewrite to use classes and make the javascript be loaded only when it needs to be. 

= 1.0.2 =
* bug fixes now it plays more nicely with other short codes.


= 1 =
* Initial Release 


