<?php
/***************************/
/* Admnistration Home page */
/***************************/

require_once("../includes/admin_init.php");
require_once("../includes/conferencesManagement.class.php");

/* Intitalize and output header */
initHeader("Home");

/* Let's create an instance of the ConferencesManagement class, which handles basic operations with all conference pages */
$conferencesManagement = new ConferencesManagement();

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();


/* Initialize page's template file */
$tpl = new Template("../templates/admin/index.tpl");  


/* On user's attempt to select a conference */
if (isset($_GET["select"])) {
 
  /* Set the conference */ 
  $adminAccount->setCurrentConference($_GET["select"]);
  
  /* Redirect to a conference's Dashboard */
  header('Location: conference_dashboard.php');
  
}


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


/* Intitalize and output footer */
initFooter();

?>