<?php
/*************************/
/* Paper Submission form */
/*************************/

require_once("includes/subForm.class.php");
require_once("includes/conference.class.php");
require_once("includes/userAccount.class.php");
require_once("includes/init.php");


/* Initialize page header */
initHeader("Paper Submission", true);

/* Initialize page's template file */
$tpl = new Template("templates/default/paper_submission.tpl"); 

/* Let's create an instance of the SubForm class, which handles paper submission form */
$subForm = new SubForm($_GET['conf']);

/* Let's create an instance of the UserAccount class, which handles all operations with User's account */
$userAccount = new UserAccount($_GET['conf']);

/* Let's create an instance of the Conference class, which handles operations with currently selected conference */
$conference = new Conference($_GET['conf']);

/* Get conference's configuration */
$conference_data = $conference->getConfiguration();


/*******************/
/* SUBMISSION FORM */
/*******************/


/* Is submission open? */
if ($conference_data['deadline_submission'] >= time()) {
  $submission_open = true;
}


if ($submission_open) {

  /* On user's attempt to submit a paper */
  if (isset($_POST["submit_paper"])) {
  
    /* Check if Type of presentation is entered */
    $err_type = empty($_POST["type"]);
    
    /* Check if Topic of presentation is entered */
    $err_topic = empty($_POST["topic"]);
    
    /* Check if Title of presentation is entered */
    $err_title = empty($_POST["title"]);
    
    /* Check if a file is selected to upload */
    $err_file = empty($_FILES["file"]["name"]);
    
    /* Check if the file has allowed file extension */
    if (!$err_file) {
      $err_file_invalid = !$subForm->checkFile($_FILES["file"]["name"]);
    }
    
    /* If there were no errors, proceed to submitting the paper */
    if ( !$err_type &&
         !$err_topic &&
         !$err_title &&
         !$err_file &&
         !$err_file_invalid  ) {
      
      /* We need to get user's data to set the correct file name and user ID later */   
      $user_data = $userAccount->getUserData(); 
    
      $subForm->addPaper($_POST["type"], $_POST["topic"], $_POST["title"], $_FILES["file"], $user_data);
      $msg_upload_success = true;
      unset($_POST);
         
    }
  }  

  /* Parse the error/success messages */
  $tpl->assignIf(array(
      "ERROR_TYPE" => $err_type,
      "ERROR_TOPIC" => $err_topic,
      "ERROR_TITLE" => $err_title,
      "ERROR_FILE" => $err_file,
      "ERROR_FILE_INVALID" => $err_file_invalid,
      "MSG_UPLOAD_SUCCESS" => $msg_upload_success,
    ));
  $tpl->parseIf();
  
  
  /* Let's select the radio button that user has already selected */
  if ($_POST["type"] == 'oral') {
  
    $oral_selected = ' checked="checked"';
    $poster_selected = '';
  
  } else if ($_POST["type"] == 'poster') {
  
    $oral_selected = '';
    $poster_selected = ' checked="checked"';
  
  }
  
  /* Give back the data back to the forms */
  $tpl->assignStr(array(
      "ORAL_SELECTED" => $oral_selected,
      "POSTER_SELECTED" => $poster_selected,
      "INPUT_TITLE" => $_POST["title"],
    ));
  
  
  /* We need to load the list of topics */
  $result = $subForm->getAllTopics();
  
  /* Now roll through all topics and prepare them for radio buttons */
  while ($data = mysqli_fetch_array($result)) {
  
    /* Has this topic been already selected? */
    if ($_POST["topic"] == $data['id']) {
      $topic_selected = ' checked="checked"';
    } else {
      $topic_selected = '';
    }
  
    /* Assign data for the loop */
    $tpl->assignLoop(array(
      "TOPICS.ID" => $data['id'],
      "TOPICS.NAME" => $data['topic'],
      "TOPICS.SELECTED" => $topic_selected,
    ));
  }
    
  /* Parse all topics */
  $tpl->parseLoop('TOPICS');
  $tpl->parseIf();
    
  /* Display submission form notes and allowed file types */
  $tpl->assignStr(array(
      "SUBFORM_NOTES" => $conference_data['subform_notes'],
      "ALLOWED_FILE_TYPES" => $conference_data['subform_file_types'],
    ));

}

/* Display deadline for submission */
$tpl->assignStr("SUBMISSION_DEADLINE", date("F jS, Y, H:i", $conference_data['deadline_submission']));
$tpl->parseStr();


/* Is the submission open or closed?*/
$tpl->assignIf(array(
          "SUBMISSION_OPEN" => $submission_open,
          "SUBMISSION_CLOSED" => !$submission_open,
        ));
$tpl->parseIf();






/*************/
/* MY PAPERS */
/*************/


/* On user's attempt to delete a paper */
if (isset($_POST["delete_paper"])) {
  
  /* Delete that paper */
  $subForm->deletePaper($_POST["delete_paper"]);
  
  /* Send a success message to the user */
  $msg_delete_success = true;

} 


/* Get user's papers*/
$result = $subForm->getPapers($userAccount->user_id);

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
      "PAPERS.URL" => '../conferences/' . $_GET['conf'] . '/' . $data['file'],
      "PAPERS.FILE_NAME" => $data['file'],
      "PAPERS.TYPE" => $data['type'],
      "PAPERS.TOPIC" => $topic_data['topic'],
      "PAPERS.TITLE" => $data['title'],
      "PAPERS.DATE" => date("F jS, Y", $data['time']),
      "PAPERS.TIME" => date("H:i", $data['time']),
    ));
    
    /* Lets assign all these ifs */
    $tpl->assignIf(array(
      "DELETE_DISABLED_". $data['id'] => !$submission_open,
      "DELETE_ENABLED_". $data['id'] => $submission_open,
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
    "MSG_DELETE_SUCCESS" => $msg_delete_success,
  ));
$tpl->parseIf();






/* Output HTML code of this page */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>