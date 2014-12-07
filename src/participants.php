<?php
/***********************************/
/* List of registered participants */
/***********************************/

require_once("includes/init.php");
require_once("includes/userAccount.class.php");

/* Intitalize and output header */
initHeader("Registered Participants");

/* Let's create an instance of the UserAccount class, which handles operations with user's account */
$userAccount = new UserAccount($_GET['conf']);

/* Initialize page's template file */
$tpl = new Template("templates/default/participants.tpl");  

/* Get all registered participants */
$result = $userAccount->getAllUsers();

/* Display regular participants */
$i = 1;
while ($data = mysqli_fetch_array($result)) {
  
  /* Assign regular participants */
  if ($data['type_of_participant'] == 'regular participant') {
  
    $tpl->assignLoop(array(
      "REGULAR.NUM" => $i,
      "REGULAR.TITLE" => $data['title'],
      "REGULAR.COUNTRY" => strtolower($data['country']),
      "REGULAR.LAST_NAME" => $data['last_name'],
      "REGULAR.FIRST_NAME" => $data['first_name'],
      "REGULAR.UNIVERSITY" => $data['university'],
    ));
    
    $i++;
  
  } 
}

/* Are there any regular participants yet? */
if ($i == 1) {
  
  $regulars_not_found = true;
  
} else {

  /* Parse regular participants */
  $tpl->parseLoop('REGULAR');

}



/* Get all registered participants */
$result = $userAccount->getAllUsers();

/* Display accompanying participants */
$i = 1;
while ($data = mysqli_fetch_array($result)) {

  if ($data['type_of_participant'] == ' accompanying person') {
  
    $tpl->assignLoop(array(
      "ACCOMP.NUM" => $i,
      "ACCOMP.TITLE" => $data['title'],
      "ACCOMP.COUNTRY" => strtolower($data['country']),
      "ACCOMP.LAST_NAME" => $data['last_name'],
      "ACCOMP.FIRST_NAME" => $data['first_name'],
    ));
   
    $i++;
  } 
}

/* Are there any accompanying persons yet? */
if ($i == 1) {
  
  $accomps_not_found = true;
  
} else {

  /* Parse accompanying participants */
  $tpl->parseLoop('ACCOMP');

}



/* Parse the found/not found messages */
$tpl->assignIf(array(
    "REGULARS_FOUND" => !$regulars_not_found,
    "REGULARS_NOT_FOUND" => $regulars_not_found,
    "ACCOMPS_FOUND" => !$accomps_not_found,
    "ACCOMPS_NOT_FOUND" => $accomps_not_found,
  ));
$tpl->parseIf();


/* Output final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>