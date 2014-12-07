<?php
/*******************/
/* Edit Topic Form */
/*******************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/subForm.class.php");

/* Intitalize and output header */
initHeader("Submission Form Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Conference class, which handles currently selected conference */
$subForm = new SubForm($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_subform_edit.tpl");


/* On user's attempt to save changes to the topic */
if (isset($_POST["edit_topic"])) {

  /* Check if Topic Title is entered */
  $err_topic_title = empty($_POST["topic"]);

  /* If the entered URL is OK and Page Title is entered, save changes to the database */
  if ( !$err_topic_title ) {

    $subForm->editTopic($_GET["id"], $_POST["topic"]);
    
    /* Redirect back to the management page */
    header('Location: conference_subform.php');
      
  }
  
} else {

  /* Get the page's data */
  $data = $subForm->getTopic($_GET['id']);
  $_POST['topic'] = $data['topic'];

}


/* Give back the data to the form */
$tpl->assignStr("INPUT_TOPIC", $_POST["topic"]);
$tpl->parseStr();


/* Parse the error/success message(s) */  
$tpl->assignIf(array(
    "ERR_TOPIC_TITLE" => $err_topic_title,
  ));
$tpl->parseIf();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>