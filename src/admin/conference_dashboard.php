<?php
/************************/
/* Conference dashboard */
/************************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/conference.class.php");
require_once("../includes/subForm.class.php");
require_once("../includes/userAccount.class.php");

/* Intitalize and output header */
initHeader("Dahsboard");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Conference class, which handles currently selected conference */
$conference = new Conference($adminAccount->getCurrentConference()); 

/* Let's create an instance of the SubForm class, which handles settings for the submission form */
$subForm = new SubForm($adminAccount->getCurrentConference()); 

/* Lets create an instance of the UserAccount class, which handles users' accounts */
$userAccount = new UserAccount($adminAccount->getCurrentConference());

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_dashboard.tpl");


/* Get the conference's data */
$conf_data = $conference->getConfiguration();


/* Get the participants's data */
$papers_data = $subForm->getPapers();
$papers_num = mysqli_num_rows($papers_data);


/* Get the papers's data */
$users_data = $userAccount->getAllUsers();
$users_num = mysqli_num_rows($users_data);


/* Assign data */
$tpl->assignStr(array(
    "PAGE_TITLE" => $conf_data["page_title"],
    "URL_ADDRESS" => $adminAccount->getConferenceURL(),
    "FULL_NAME" => $conf_data["name"],
    "SUBTITLE" => $conf_data["name_subtitle"],
    "PARTICIPANTS_NUM" => $users_num,
    "PAPERS_NUM" => $papers_num,
    "REGISTRATION_DEADLINE" => date("F jS, Y, H:i", $conf_data['deadline_registration']),
    "SUBMISSION_DEADLINE" => date("F jS, Y, H:i", $conf_data['deadline_submission']),
    "CONFERENCE_URL" => $adminAccount->getCurrentConference(),
  ));

$tpl->parseStr();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>