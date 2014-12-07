<?php
/******************************/
/* Page with optional content */
/******************************/

require_once("includes/pages.class.php");

/* Let's create an instance of the Pages class, which handles pages with optional content */
$pages = new Pages($_GET['conf']);

/* Get page's data from the database */
$data = $pages->getPage($pages->urlToId($_GET['page']));

require_once("includes/init.php");

/* Intitalize and output header */
initHeader($data['title']);


/* Initialize page's template file */
$tpl = new Template("templates/default/page.tpl");  


/* Assign and output HTML code of this page */
$tpl->assignStr("PAGE_HTML", $data['html']);
$tpl->parseStr();
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>