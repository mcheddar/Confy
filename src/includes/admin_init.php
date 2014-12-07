<?php
/*******************************/
/* Header and footer functions */
/*******************************/


/* Performs all necessary actions before we process any page in the administration */ 
function initHeader($page_title) {

  /* First, we need to include the functions file and some classes */ 
  require_once("functions.php");
  require_once("template.class.php");
  require_once("adminAccount.class.php");
  require_once('conferencesManagement.class.php');
  
  
  /* Lets create an instance of the AdminAccount class, which handles administrator's account */
  $adminAccount = new AdminAccount();
  
  /* If administrator is not logged in, redirect to the login page */
  if ($adminAccount->isLogged() == false) {
  
    header('Location: ../admin/login.php'); 
  
  }
  
  /* Intialize the header template */
  $header = new Template("../templates/admin/header.tpl");
  
  
  /* Let's create an instance of the ConferencesManagement class, which handles basic operations with all conference pages */
  $conferencesManagement = new ConferencesManagement();
  
  
  /* Set conference selected by user */
  if (isset($_POST['conference_select'])) {
  
    $adminAccount->setCurrentConference($_POST['conference_select']);
    
    /* Redirect to the Conference Dashboard */
    header('Location: ../admin/conference_dashboard.php'); 
  
  }
  
  
  /* Get an array of URLs and titles of all the conferences */
  $conferences = $conferencesManagement->getConferences();
  
  /* Are there any conferences yet? */
  if (count($conferences) == 0) {
    
    $conferences_not_found = true;
    
  } else {
  
    /* Generate drop down menu of all existing conferences */
    foreach ($conferences as $url => $title) {
      
      /* Prepare SELECTED attribute for html if the conference is currently selected */
      if ($adminAccount->getCurrentConference() == $url) {
        $selected = ' selected="selected"';
      } else {
        $selected = '';
      }
      
      /* Assign data for the loop */
      $header->assignLoop(array(
        "CONFERENCES_LIST.URL" => $url,
        "CONFERENCES_LIST.TITLE" => $title,
        "CONFERENCES_LIST.SELECTED" => $selected,
      ));
    }
  
    $header->parseLoop('CONFERENCES_LIST');
    
  }
  
  /* Parse the found/not found messages */
  $header->assignIf(array(
      "CONFERENCES_FOUND" => !$conferences_not_found,
      "CONFERENCES_NOT_FOUND" => $conferences_not_found,
    ));
  $header->parseIf();
  
  
  /* If any conference is selected, display its administration menu */
  $header->assignIf("CONFERENCE_SELECTED", $adminAccount->getCurrentConference());
  $header->parseIf();
  
  /* Assign current conference title and url (if selected) and page title */
  $header->assignStr(array(
    "CONFERENCE_TITLE" => $conferences[$adminAccount->getCurrentConference()],
    "CONFERENCE_URL" => $adminAccount->getCurrentConference(),
    "PAGE_TITLE" => $page_title,
  ));
  $header->parseStr();
  
  /* Output header */
  $header->output();

}



/* Performs all necessary actions after we process any page in the administration */
function initFooter() {

  // Initialize and output the footer */
  $footer = new Template("../templates/admin/footer.tpl");
  $footer->output();

}


?>