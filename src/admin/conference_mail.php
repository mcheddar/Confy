<?php
/***********************/
/* Mass E-mail sending */
/***********************/

require_once("../includes/admin_init.php");
require_once("../includes/conference.class.php");
require_once("../includes/adminAccount.class.php");

/* Intitalize and output header */
initHeader("Mass Message");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Conference class, which handles currently selected conference */
$conference = new Conference($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_mail.tpl"); 


/* Get the configuration data */
$data = $conference->getConfiguration();


/* On user's attempt to send an e-mail */
if (isset($_POST['send_email'])) {

  /* Check if the Message Subject is filled */
  $err_subject = empty($_POST['subject']);
  
  /* Check if the Message Text is filled */
  $err_text = empty($_POST['text']);

  /* Check if List of Recipients is filled */
  $err_list = (($_POST['recipients'] == 1) && empty($_POST['recipients_list']));

  /* If the form is OK, send the mass e-mail */
  if (!$err_subject && !$err_text && !$err_list) {
  
    if ($_POST['recipients'] == 1) {
    
      /* Send e-mail to specified recipients */
      $conference->sendMassEmail($_POST['subject'], $_POST['text'], $_FILES["attachment"], $_POST['recipients_list']);
      
    } else {
    
      /* Send e-mail to all registered participants */
      $conference->sendMassEmail($_POST['subject'], $_POST['text'], $_FILES["attachment"]);
      
    }
  
    /* Display success message */
    $msg_success = true;
    unset($_POST);
  
  }

}

/* If Recipients type was already chosen, let it stay this way */
if ($_POST['recipients'] == 1) {
  $all_checked = '';
  $other_checked = ' checked="checked"';
} else {
  $all_checked = ' checked="checked"';
  $other_checked = '';
}

/* Pass the data to the template file */
$tpl->assignStr(array(
  "INPUT_SUBJECT" => $_POST['subject'],
  "INPUT_TEXT" => $_POST['text'],
  "INPUT_RECIPIENTS_LIST" => $_POST['recipients_list'],
  "INPUT_ALL_CHECKED" => $all_checked,
  "INPUT_OTHER_CHECKED" => $other_checked,
));
$tpl->parseStr();


/* Parse the error/success message(s) */ 
$tpl->assignIf(array(
  "ERR_SUBJECT" => $err_subject,
  "ERR_TEXT" => $err_text,
  "ERR_LIST" => $err_list,
  "MSG_SUCCESS" => $msg_success, 
)); 
$tpl->parseIf();


/* Output final html code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>