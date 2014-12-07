<?php 

/* The content type is CSS (not HTML!) */
header("Content-type: text/css"); 

require_once("../../includes/appearance.class.php");

/* Let's create an instance of the Appearance class, which handles operations with design changes */
$appearance = new Appearance($_GET['conf']); 

/* Get color codes from the database */
$COLORS = $appearance->getColors();

?>

html {
  height: 100%;
}

body {
  background: <?= $COLORS["app_body_background"] ?> url(../../conferences/<?= $_GET['conf'] ?>/images/bcg.png) repeat-x;
  color: <?= $COLORS["app_body_text"] ?>;
  font-family: "Trebuchet MS", Arial, Verdana, Tahoma, sans-serif;
  font-size: 90%;
  margin: 0;
  padding: 0;
  height: 100%;
}

#main {
  width: 776px;
  background: <?= $COLORS["app_main_background"] ?>;
  height: 100%;
}

#banner {
  padding: 4px;
}

#header {
  font-family: Times New Roman, Helvetica, Arial, Verdana, Tahoma, sans-serif;
  width: 768px;
  text-align: center;
  border-collapse: collapse;
}

#lines {
  height: 2px;
  font-size: 0px;
  border-top: 5px solid <?= $COLORS["app_lines_top"] ?>;
  border-bottom: 5px solid <?= $COLORS["app_lines_bottom"] ?>;
  margin: 5px 4px 5px 4px;
  clear: both;
}

#content {
  clear: both;
  padding: 20px;
  text-align: left;
  min-height: 100%;
}

#footer {
  clear: both;
  margin: 20px 4px 0 4px;
  padding: 6px 20px 10px 20px;
  border-top: 2px solid <?= $COLORS["app_lines_top"] ?>;
}

h1 {
  font-size: 150%;
  font-weight: 300;
  margin: 5px 0 5px 0;
}

h2 {
  font-size: 130%;
  display: block;
  border-bottom: 1px solid <?= $COLORS["app_h2_line"] ?>;
}

a:link {
  color: <?= $COLORS["app_a_link"] ?>; 
  text-decoration: underline;
  font-weight: bold;
}

a:visited {
	color: <?= $COLORS["app_a_link"] ?>; 
  text-decoration: underline;
  font-weight: bold;
}

a:hover {
	color: <?= $COLORS["app_a_hover"] ?>; 
  text-decoration: underline;
  font-weight: bold;
}

img.icon {
  padding: 1px 3px 0 0;
  float: left;
}

.subtitle {
  font-size: 110%;
}

table tr td.label {
  text-align: right;
}

table.papers {
  border-collapse: collapse;
}

table.papers tr {
  background: <?= $COLORS["app_table_1"] ?>;
}

table.papers tr.even {
  background: <?= $COLORS["app_table_2"] ?>;
}

table.papers tr th {
  color: <?= $COLORS["app_table_head_text"] ?>;
  background: <?= $COLORS["app_table_head"] ?>;
  border: 1px solid <?= $COLORS["app_table_head"] ?>;
}

table.papers tr td {
  border: 1px solid <?= $COLORS["app_table_border"] ?>;
  padding: 3px;
}

.menu {
  font-family: Arial, Verdana, Tahoma, sans-serif;
  display: block;
  text-align: center;
  margin: 15px 10px 15px 10px;
  position: relative;
}

.menu ul {
  clear: left;
  float: right;
	height: 25px;
	list-style: none;
	margin: 0;
	padding: 0;
  font-size: 90%;
  text-align: center;
  position: relative;
  right: 50%;
}

.menu li {
  display:block;
  float: left;
  left: 50%;
  list-style: none;
  position: relative;
  padding: 0;
  margin: 0;    
}

.menu li a {
	background: <?= $COLORS["app_menu_mainitem_bcg"] ?>;
  color: <?= $COLORS["app_menu_mainitem_text"] ?>;
  border-left: 1px solid <?= $COLORS["app_main_background"] ?>;
	display: block;
	font-weight: bolder;
	line-height: 25px;
	margin: 0px;
	padding: 0px 10px;
	text-align: center;
	text-decoration: none; 
}

.menu ul li a:hover {
	background: <?= $COLORS["app_menu_mainitem_bcg_hover"] ?>;
	color: <?= $COLORS["app_menu_mainitem_text_hover"] ?>;
	text-decoration: none;
}

.menu ul li:hover a {
	background: <?= $COLORS["app_menu_mainitem_bcg_hover"] ?>;
	color: <?= $COLORS["app_menu_mainitem_text_hover"] ?>;
	text-decoration: none;
}

.menu li ul {
  color: <?= $COLORS["app_menu_subitem_text"] ?>; 
	background: <?= $COLORS["app_menu_subitem_bcg"] ?>;
	display: none;
	height: auto;
  width: 140px;
	padding: 0px;
	margin: 0px;
	border: 1px solid <?= $COLORS["app_menu_subitem_border"] ?>;
	position: absolute;
	z-index: 200;  
  right: auto;
}

.menu li ul li a {
  color: <?= $COLORS["app_menu_subitem_text"] ?>;
  border: none;  
}


.menu li:hover ul {
	display: block;         
}

.menu li li {
	display: block;
	float: none;
	margin: 0px;
	padding: 0px;
	width: auto;
  left: auto;
  clear:left;
}

.menu li:hover li a {
  color: <?= $COLORS["app_menu_subitem_text"] ?>;
	background: none;  
}

.menu li ul a {
	display: block;
	height: auto;
	font-size: 95%;
	font-weight: normal;
	margin: 0px;
	padding: 0px 10px 0px 10px;
	text-align: left;  
}

.menu li ul a:hover, .menu li ul li:hover a{
	background: <?= $COLORS["app_menu_subitem_bcg_hover"] ?>;
	border:0px;
	color:<?= $COLORS["app_menu_subitem_text_hover"] ?>;
	text-decoration:none;     
}

.menu p {
	clear:left;  
}	

#popup_container {
	font-family: Arial, sans-serif;
	font-size: 12px;
	min-width: 300px; /* Dialog will be no smaller than this */
	max-width: 600px; /* Dialog will wrap after this width */
	background: <?= $COLORS["app_main_background"] ?>;
	border: solid 5px #999;
	color: <?= $COLORS["app_body_text"] ?>;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}

#popup_title {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	line-height: 1.75em;
	color: #666;
	background: #CCC url(images/title.gif) top repeat-x;
	border: solid 1px <?= $COLORS["app_main_background"] ?>;
	border-bottom: solid 1px #999;
	cursor: default;
	padding: 0em;
	margin: 0em;
}

#popup_content {
	background: 16px 16px no-repeat url(images/icon32_info.png);
	padding: 1em 1.75em;
	margin: 0em;
}

#popup_content.alert {
	background-image: url(images/icon32_info.png);
}

#popup_content.confirm {
	background-image: url(images/icon32_question.png);
}

#popup_content.prompt {
	background-image: url(images/icon32_question.png);
}

#popup_message {
	padding-left: 48px;
}

#popup_panel {
	text-align: center;
	margin: 1em 0em 0em 1em;
}

#popup_prompt {
	margin: .5em 0em;
}

