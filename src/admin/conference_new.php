<?php
/*************************************/
/* Admnistration New conference page */
/*************************************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/conferencesManagement.class.php");

/* Intitalize and output header */
initHeader("New Conference");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the ConferencesManagement class, which handles basic operations with all conference pages */
$conferencesManagement = new ConferencesManagement();


/* On user's attempt to create a new conference */
if (isset($_POST["new_conference"])) {
 
  /* Check if the entered URL is available */
  $err_url_assigned = !$conferencesManagement->checkUrlAvailable($_POST["url"]);
  
  /* Check if the entered URL is valid */
  $err_url_invalid = !$conferencesManagement->checkUrlValid($_POST["url"]);
  
  /* Check if the entered URL has the right length */
  $err_url_too_short = !$conferencesManagement->checkUrlLength($_POST["url"]);

  /* If the entered URL is OK, create a new conference */
  if ( !$err_url_assigned &&
       !$err_url_invalid &&
       !$err_url_too_short ) {

    $conferencesManagement->createNewConference($_POST["url"]);
    
    $adminAccount->setCurrentConference($_POST["url"]);
    
    header('Location: conference_configuration.php');
      
  }
  
}

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_new.tpl");  

/* Give back the entered values to the form */
$tpl->assignStr("INPUT_URL", $_POST["url"]);

/* Detect the URL address where the Confy system is running on */
$systemURL = substr(currentURL(), 0, strpos(currentURL(), 'admin/'));
$tpl->assignStr("CURRENT_URL", $systemURL);

$tpl->parseStr();

/* Parse the error message(s) */  
$tpl->assignIf(array(
    "ERR_URL_ASSIGNED" => $err_url_assigned,
    "ERR_URL_INVALID" => $err_url_invalid,
    "ERR_URL_TOO_SHORT" => $err_url_too_short,
  ));
$tpl->parseIf();

/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>