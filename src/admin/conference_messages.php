<?php
/****************************/
/* Conference Messages page */
/****************************/

require_once("../includes/admin_init.php");
require_once("../includes/messages.class.php");
require_once("../includes/adminAccount.class.php");

/* Intitalize and output header */
initHeader("Messages & E-mails");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Conference class, which handles currently selected conference */
$messages = new Messages($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_messages.tpl"); 


/* On user's form changes confirmation */
if (isset($_POST['change_messages'])) {

  /* Add slashes to messages */
  foreach($_POST as $setting => $value) {
    $_POST[$setting] = addslashes($_POST[$setting]);
  }

  /* Set the new configuration */
  $messages->setMessages($_POST);
    
  /* Display confirmation message */
  $msg_success = true;

}

/* Get the messages data */
$data = $messages->getMessages();

/* Strip slashes from the messages */
foreach($data as $setting => $value) {
  $data[$setting] = stripslashes($data[$setting]);
}



/* Pass the data to the template file */
$tpl->assignStr(array(
  "EMAIL_NEW_REGISTRATION_TEXT" => $data['email_new_registration_text'],
  "EMAIL_NEW_REGISTRATION_SUBJECT" => $data['email_new_registration_subject'],
  "EMAIL_CHANGE_REGISTRATION_TEXT" => $data['email_change_registration_text'],
  "EMAIL_CHANGE_REGISTRATION_SUBJECT" => $data['email_change_registration_subject'],
  "EMAIL_NEW_PASSWORD_TEXT" => $data['email_new_password_text'],
  "EMAIL_NEW_PASSWORD_SUBJECT" => $data['email_new_password_subject'],
  "EMAIL_NEW_CONTRIBUTION_TEXT" => $data['email_new_contribution_text'],
  "EMAIL_NEW_CONTRIBUTION_SUBJECT" => $data['email_new_contribution_subject'],
  "EMAIL_DELETE_CONTRIBUTION_TEXT" => $data['email_delete_contribution_text'],
  "EMAIL_DELETE_CONTRIBUTION_SUBJECT" => $data['email_delete_contribution_subject'],
  "MSG_NEW_REGISTRATION" => $data['msg_new_registration'],
));
$tpl->parseStr();


/* Parse the error/success message(s) */ 
$tpl->assignIf("MSG_SUCCESS", $msg_success); 
$tpl->parseIf();


/* Output final html code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>