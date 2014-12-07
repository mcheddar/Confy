<?php
/******************************/
/* Submission Form Management */
/******************************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/subForm.class.php");
require_once("../includes/conference.class.php");

/* Intitalize and output header */
initHeader("Submission Form Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the SubForm class, which handles settings for the submission form */
$subForm = new SubForm($adminAccount->getCurrentConference()); 

/* Let's create an instance of the Conference class, which handles operations with currently selected conference */
$conference = new Conference($adminAccount->getCurrentConference());

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_subform.tpl");


/* On user's attempt to add a new topic */
if (isset($_POST["new_topic"])) {
 
  /* Check if Topic Title is entered */
  $err_topic_title = empty($_POST["topic"]);

  /* If Page Title is entered, add a new topic */
  if ( !$err_topic_title ) {

    /* Add topic to the DB */
    $subForm->addTopic($_POST["topic"]);
    
    /* Send a success message to the user */
    $msg_add_success = true;
      
  }
  
}

/* On user's attempt to delete a topic */
if (isset($_POST["delete_topic"])) {

  /* Delete that page */
  $subForm->deleteTopic($_POST["delete_topic"]);
  
  /* Send a success message to the user */
  $msg_delete_success = true;
  
}


/* On user's attempt to save submission form notes */
if (isset($_POST["edit_subform_notes"])) {

  /* Save notes to the database */
  $subForm->editNotes($_POST["subform_notes"]);
  
  /* Show user a success message */
  $msg_notes_success = true;
 
}


/* On user's attempt to save allowed file types */
if (isset($_POST["edit_file_types"])) {

  /* Save file types to the database */
  $subForm->editFileTypes($_POST["file_types"]);
  
  /* Show user a success message */
  $msg_file_types_success = true;
 
}


/* Lets assign each topic's data to the template file */
$result = $subForm->getAllTopics();

/* Are there any topics yet? */
if (mysqli_num_rows($result)) {

  $topics_found = true;

  $i = 1;
  while ($data = mysqli_fetch_array($result)) {
  
    /* If even iteration, we need to display different style of table */
    if ($i % 2 == 0) {
      $even = ' class="even"';
    } else {
      $even = '';
    }
  
    /* Assign data for the loop */
    $tpl->assignLoop(array(
      "TOPICS.ID" => $data['id'],
      "TOPICS.TITLE" => $data['topic'],
      "TOPICS.EVEN" => $even,
    ));
    
    $i++;
  
  }
  
  $tpl->parseLoop('TOPICS');
  $tpl->parseIf();

/* No topics yet */
} else {

  $topics_not_found = true;
  
}


/* Parse the error/success message(s) */  
$tpl->assignIf(array(
    "TOPICS_FOUND" => $topics_found,
    "TOPICS_NOT_FOUND" => $topics_not_found,
    "ERR_TOPIC_TITLE" => $err_topic_title,
    "MSG_DELETE_SUCCESS" => $msg_delete_success,
    "MSG_ADD_SUCCESS" => $msg_add_success,
    "MSG_NOTES_SUCCESS" => $msg_notes_success,
    "MSG_FILE_TYPES_SUCCESS" => $msg_file_types_success,
  ));
$tpl->parseIf();


/* Get conference's configuration */
$conference_data = $conference->getConfiguration();

/* Assign and parse the submission form notes and allowed file types */
$tpl->assignStr(array(
    "SUBFORM_NOTES" => $conference_data['subform_notes'],
    "SUBFORM_FILE_TYPES" => $conference_data['subform_file_types'],
  ));
$tpl->parseStr();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>