=== Plugin Name ===
Contributors: enej, ctltdev, oltdev

Tags: tab, shortcode
Requires at least: 3.0
Tested up to: 3.3
Stable tag: trunk

Lets you add tabs to your post and pages using a shortcode. 

== Description ==

by using the following shortcodes

[tabs]
[tab title="title1"] tab content [/tab]
[tab title="title2"] another content tab [/tab]
[/tabs] 

*note* that you need to add css to your themes style sheet to make the tabs look the way you want

== Installation ==

regular wordpress install + adding css to your theme.

here is some css to get you stated
'
/* =tabs
-------------------------------------------------------------- */
.ui-tabs {
    padding:0;
    zoom:1;
}
.ui-tabs .ui-tabs-nav {
    list-style:none;
    position:relative;
    padding: 0;
    margin: 0;
    zoom:1;
}
.ui-tabs .ui-tabs-nav li {
    position:relative;
    float:left;
    border-bottom-width:0!important;
    margin:0;
    padding:0;
}
.ui-tabs .ui-tabs-nav li a {
    float:left;
    text-decoration:none;
    padding:1px 12px;
    background: #7491a3; /* Secondary Emphasis */
    color:#FFF;
    margin-right:1px;
}
.ui-tabs .ui-tabs-nav li a:hover{
    background:;
    background-color: #002859; /* Primary Emphasis */
    color:#FFF;
    padding-bottom:8px;
    text-decoration: none;
}
.ui-tabs .ui-tabs-nav li.ui-tabs-selected {
    padding-bottom:8px;
    border-bottom-width:0;
}
.ui-tabs .ui-tabs-nav li.ui-tabs-selected a,.ui-tabs .ui-tabs-nav li.ui-state-disabled a,.ui-tabs .ui-tabs-nav li.ui-state-processing a {
    cursor:text;
    background: ;
    background-color: #002859; /* Primary Emphasis */
    color:#FFF;
    padding-bottom: 8px;
}
.ui-tabs .ui-tabs-nav li a,.ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a {
    cursor:pointer;
}

/* first selector in group seems obsolete, but required to overcome bug in Opera applying cursor: text overall if defined elsewhere... */
.ui-tabs .ui-tabs-panel {
    padding:10px;
    display:block;
    border-width:0;
    background:none;
    clear:both;
}
.ui-tabs .ui-tabs-hide {
    display: none !important;
}
/* vertical tabs */
.vertical-tabs .ui-tabs-nav{
	width:170px;
	float:left;
}
.vertical-tabs .ui-tabs-nav a{
	display: block;
	width:146px;
	padding:5px 12px;
}
.vertical-tabs{
	position:relative;
	overflow:hidden;
}
.vertical-tabs .ui-tabs-panel{
	float:right;
	width:360px;
	clear:none;
	padding:0;
}

.vertical-tabs .ui-tabs-nav li.ui-tabs-selected a, 
.vertical-tabs .ui-tabs-nav li.ui-state-disabled a, 
.vertical-tabs .ui-tabs-nav li.ui-state-processing a,
.vertical-tabs .ui-tabs-nav li a:hover{
	padding-bottom:1px;
	background:#002859; /* Primary Emphasis */
}
.vertical-tabs .ui-tabs-nav li.ui-tabs-selected{
	padding-bottom:0;
}
'

== Changelog ==
0.6
* updated reliese with some js options

0.5
* initial release 


