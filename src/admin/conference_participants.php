<?php
/***********************************/
/* List of Registered Participants */
/***********************************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/userAccount.class.php");
require_once("../includes/subForm.class.php");

/* Intitalize and output header */
initHeader("Participants Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Lets create an instance of the UserAccount class, which handles users' accounts */
$userAccount = new UserAccount($adminAccount->getCurrentConference());

/* Let's create an instance of the SubForm class, which handles operations with contributions and submission form */
$subForm = new SubForm($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_participants.tpl");



/* Get all registered participants */
$result = $userAccount->getAllUsers();

/* Display all participants */
$i = 1;
while ($data = mysqli_fetch_array($result)) {

  /* If even iteration, we need to display different style of table */
  if ($i % 2 == 0) {
    $even = ' class="even"';
  } else {
    $even = '';
  } 
  
  /* Determine the number of user's papers */
  $result_papers = $subForm->getPapers($data['id']);
  $papers_count = mysqli_num_rows($result_papers);
  
  
  /* Assign data for the loop */
  $tpl->assignLoop(array(
      "PARTICIPANTS.NUM" => $i,
      "PARTICIPANTS.EVEN" => $even,
      "PARTICIPANTS.ID" => $data['id'],
      "PARTICIPANTS.COUNTRY" => strtolower($data['country']),
      "PARTICIPANTS.NAME" => $data['last_name'] . ' ' . $data['first_name'],
      "PARTICIPANTS.UNIVERSITY" => $data['university'],
      "PARTICIPANTS.PAPERS" => $papers_count,
    ));
    
  $i++;

}

/* Are there any participants yet? */
if ($i == 1) {
  
  $participants_not_found = true;
  
} else {

  /* Parse participants */
  $tpl->parseLoop('PARTICIPANTS');

}

/* Parse the found/not found messages */
$tpl->assignIf(array(
    "PARTICIPANTS_FOUND" => !$participants_not_found,
    "PARTICIPANTS_NOT_FOUND" => $participants_not_found,
  ));
$tpl->parseIf();

/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>