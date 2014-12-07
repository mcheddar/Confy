<?php
/****************************/
/* Contributions Management */
/****************************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/userAccount.class.php");
require_once("../includes/subForm.class.php");
require_once("../includes/regForm.class.php");

/* Intitalize and output header */
initHeader("Contributions Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Lets create an instance of the UserAccount class, which handles users' accounts */
$userAccount = new UserAccount($adminAccount->getCurrentConference());

/* Let's create an instance of the SubForm class, which handles operations with contributions and submission form */
$subForm = new SubForm($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_contributions.tpl");


/* Get all papers*/
$result = $subForm->getPapers();

/* If there are no contributed papers, do not show the table */
if (mysqli_num_rows($result) == 0) {
  
  $papers_not_found = true;
  
} else {

  $papers_found = true;
  
  /* Let's roll through all papers */
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
    
    /* Get the name of the author */
    $author_data = $userAccount->getUserData($data['author']);
  
    /* Assign data for the loop */
    $tpl->assignLoop(array(
      "PAPERS.NUM" => $i,
      "PAPERS.EVEN" => $even,
      "PAPERS.ID" => $data['id'],
      "PAPERS.URL" => '../conferences/' . $adminAccount->getCurrentConference() . '/' . $data['file'],
      "PAPERS.FILE_NAME" => $data['file'],
      "PAPERS.AUTHOR_ID" => $data['author'],
      "PAPERS.AUTHOR_NAME" => $author_data['last_name'] . ' ' . $author_data['first_name'],
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