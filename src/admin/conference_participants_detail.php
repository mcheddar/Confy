<?php
/***********************/
/* Participant Detail */
/**********************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/userAccount.class.php");
require_once("../includes/subForm.class.php");
require_once("../includes/regForm.class.php");

/* Intitalize and output header */
initHeader("Participants Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Lets create an instance of the UserAccount class, which handles users' accounts */
$userAccount = new UserAccount($adminAccount->getCurrentConference());

/* Let's create an instance of the SubForm class, which handles operations with contributions and submission form */
$subForm = new SubForm($adminAccount->getCurrentConference()); 

/* Let's create an instance of the SubForm class, which handles operations with registration form */
$regForm = new RegForm($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_participants_detail.tpl");


/* Get user's data */
$user_data = $userAccount->getUserData($_GET['id']);

/* Get registration form's data from the database */
$result = $regForm->getAllFields();

/* Now roll through all fields and print the data */
while ($data = mysqli_fetch_array($result)) {

  /* We don't need to print titles titles */
  if ($data['type'] != 'title') {
  
    /* Convert country code to country name */
    if ($data['type'] == 'country_select') {
      $user_data[$data['db_column']] = convertCountry($user_data[$data['db_column']]);
    }
    
    /* Print all values which are not empty */
    if (!empty($user_data[$data['db_column']])) {
        
      $tpl->assignLoop(array(
            "DETAILS.CAPTION" => $data['caption'],
            "DETAILS.DATA" => $user_data[$data['db_column']],
        ));
      
    }
      
  }
  
}


$tpl->parseLoop('DETAILS');

/* Assign participant's full name */
$tpl->assignStr("PARTICIPANT_NAME", $data['last_name'] . ' ' . $data['first_name']);
$tpl->parseStr();

/* Get user's papers*/
$result = $subForm->getPapers($_GET['id']);

/* If the user hasn't contributed any papers yet, do not show the table */
if (mysqli_num_rows($result) == 0) {
  
  $papers_not_found = true;
  
} else {

  $papers_found = true;
  
  /* Let's roll through all user's papers */
  $i = 1;
  while ($data = mysqli_fetch_array($result)) {
  
    /* If even iteration, we need to display different style of table */
    if ($i % 2 == 0) {
      $even = ' class="even"';
    } else {
      $even = '';
    }
    
    /* Get the name of the topic */
    $topic_data = $subForm->getTopic($data['topic']);
  
    /* Assign data for the loop */
    $tpl->assignLoop(array(
      "PAPERS.NUM" => $i,
      "PAPERS.EVEN" => $even,
      "PAPERS.ID" => $data['id'],
      "PAPERS.URL" => '../conferences/' . $adminAccount->getCurrentConference() . '/' . $data['file'],
      "PAPERS.FILE_NAME" => $data['file'],
      "PAPERS.TYPE" => $data['type'],
      "PAPERS.TOPIC" => $topic_data['topic'],
      "PAPERS.TITLE" => $data['title'],
      "PAPERS.DATE" => date("F jS, Y", $data['time']),
      "PAPERS.TIME" => date("H:i", $data['time']),
    ));
    
    $i++;
  
  }
  
  /* Parse all papers */
  $tpl->parseLoop('PAPERS');
  $tpl->parseIf;

}

/* Parse the found/not found message */
$tpl->assignIf(array(
    "PAPERS_FOUND" => $papers_found,
    "PAPERS_NOT_FOUND" => $papers_not_found,
  ));
$tpl->parseIf();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>