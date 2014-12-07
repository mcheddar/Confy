<?php
/*********************************/
/* Conference Configuration page */
/*********************************/

require_once("../includes/admin_init.php");
require_once("../includes/conference.class.php");
require_once("../includes/adminAccount.class.php");

/* Intitalize and output header */
initHeader("Configuration");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Conference class, which handles currently selected conference */
$conference = new Conference($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_configuration.tpl"); 


/* Get the configuration data */
$data = $conference->getConfiguration();


/* On user's form changes confirmation */
if (isset($_POST['change_configuration'])) {

  $_POST['deadline_registration'] = convertDate($_POST['deadline_registration_day'], $_POST['deadline_registration_month'], $_POST['deadline_registration_year'], $_POST['deadline_registration_hour'], $_POST['deadline_registration_min']);
  $_POST['deadline_submission'] = convertDate($_POST['deadline_submission_day'], $_POST['deadline_submission_month'], $_POST['deadline_submission_year'], $_POST['deadline_submission_hour'], $_POST['deadline_submission_min']);

  /* Load POST data to our data array */
  foreach($_POST as $setting => $value) {
    $data[$setting] = stripslashes($_POST[$setting]);
  }

  /* Check if the Page Title is filled */
  $err_page_title = empty($_POST['page_title']);
  
  /* Check if Date Format is correct */
  $err_date_format = !($_POST['deadline_registration'] && $_POST['deadline_submission']);

  /* If the form is OK, update data in database */
  if (!$err_page_title && !$err_date_format) {
    
    /* Set the new configuration */
    $conference->setConfiguration($data);
    
    /* Display confirmation message */
    $msg_success = true;
  
  }

} else {

  /* Load the timestamp to POST array */
  $_POST['deadline_registration_day'] = date('d', $data['deadline_registration']);
  $_POST['deadline_registration_month'] = date('m', $data['deadline_registration']);
  $_POST['deadline_registration_year'] = date('Y', $data['deadline_registration']);
  $_POST['deadline_registration_hour'] = date('H', $data['deadline_registration']);
  $_POST['deadline_registration_min'] = date('i', $data['deadline_registration']);
  $_POST['deadline_submission_day'] = date('d', $data['deadline_submission']);
  $_POST['deadline_submission_month'] = date('m', $data['deadline_submission']);
  $_POST['deadline_submission_year'] = date('Y', $data['deadline_submission']);
  $_POST['deadline_submission_hour'] = date('H', $data['deadline_submission']);
  $_POST['deadline_submission_min'] = date('i', $data['deadline_submission']);

}


/* Pass the data to the template file */
$tpl->assignStr(array(
  "INPUT_PAGE_TITLE" => $data['page_title'],
  "INPUT_NAME" => $data['name'],
  "INPUT_NAME_SUBTITLE" => $data['name_subtitle'],
  "INPUT_META_KEYWORDS" => $data['meta_keywords'],
  "INPUT_META_REPLY_TO" => $data['meta_reply_to'],
  "INPUT_META_CATEGORY" => $data['meta_category'],
  "INPUT_META_RATING" => $data['meta_rating'],
  "INPUT_META_ROBOTS" => $data['meta_robots'],
  "INPUT_META_REVISIT_AFTER" => $data['meta_revisit_after'],
  "INPUT_META_TITLE" => $data['meta_title'],
  "INPUT_DEADLINE_REGISTRATION_DAY" => $_POST['deadline_registration_day'],
  "INPUT_DEADLINE_REGISTRATION_MONTH" => $_POST['deadline_registration_month'],
  "INPUT_DEADLINE_REGISTRATION_YEAR" => $_POST['deadline_registration_year'],
  "INPUT_DEADLINE_REGISTRATION_HOUR" => $_POST['deadline_registration_hour'],
  "INPUT_DEADLINE_REGISTRATION_MIN" => $_POST['deadline_registration_min'],
  "INPUT_DEADLINE_SUBMISSION_DAY" => $_POST['deadline_submission_day'],
  "INPUT_DEADLINE_SUBMISSION_MONTH" => $_POST['deadline_submission_month'],
  "INPUT_DEADLINE_SUBMISSION_YEAR" => $_POST['deadline_submission_year'],
  "INPUT_DEADLINE_SUBMISSION_HOUR" => $_POST['deadline_submission_hour'],
  "INPUT_DEADLINE_SUBMISSION_MIN" => $_POST['deadline_submission_min'],
  "INPUT_CONFERENCE_EMAIL" => $data['conference_email'],
  "INPUT_PAGE_FOOTER" => $data['page_footer'],
));
$tpl->parseStr();


/* Parse the error/success message(s) */ 
$tpl->assignIf(array(
  "ERR_PAGE_TITLE" => $err_page_title,
  "ERR_DATE_FORMAT" => $err_date_format,  
  "MSG_SUCCESS" => $msg_success, 
)); 
$tpl->parseIf();


/* Output final html code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>