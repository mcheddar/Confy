<?php
/*******************/
/* confy Home page */
/******************/

/* First, we need to include the functions file and some classes */ 
require_once("includes/functions.php");
require_once("includes/template.class.php");
require_once("includes/conferencesManagement.class.php");


/* Let's create an instance of the ConferencesManagement class, which handles basic operations with all conference pages */
$conferencesManagement = new ConferencesManagement();


/* Initialize page's template file */
$tpl = new Template("templates/admin/homepage.tpl");  


/* Get all conferences */
$data = $conferencesManagement->getConferences();


/* Are there any conferences yet? */
if (count($data) == 0) {
  
  $conferences_not_found = true;
  
} else {

  /* Output the list of conferences */
  foreach($data as $url => $name) {
  
    /* Assign data for the loop */
    $tpl->assignLoop(array(
      "CONFERENCES.URL" => $url,
      "CONFERENCES.NAME" => $name,
    ));

  }

  /* Parse conferences */
  $tpl->parseLoop("CONFERENCES");

}


/* Parse the found/not found messages */
$tpl->assignIf(array(
    "CONFERENCES_FOUND" => !$conferences_not_found,
    "CONFERENCES_NOT_FOUND" => $conferences_not_found,
  ));
$tpl->parseIf();


$tpl->output();



?>