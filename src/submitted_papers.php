<?php
/****************************/
/* List of submitted papers */
/****************************/

require_once("includes/init.php");
require_once("includes/subForm.class.php");
require_once("includes/userAccount.class.php");

/* Intitalize and output header */
initHeader("Submitted Papers");

/* Let's create an instance of the SubForm class, which handles operations with contributions and submission form */
$subForm = new SubForm($_GET['conf']);

/* Let's create an instance of the UserAccount class, which handles operations with user's account */
$userAccount = new UserAccount($_GET['conf']);

/* Initialize page's template file */
$tpl = new Template("templates/default/submitted_papers.tpl");  

/* Get all contributed papers */
$result = $subForm->getPapers();


/* Display oral presentations */
$i = 1;
while ($data = mysqli_fetch_array($result)) {
    
  /* Assign oral presentations */
  if ($data['type'] == 'oral') {
    
    $user_data = $userAccount->getUserData($data['author']);
    
    $tpl->assignLoop(array(
      "ORAL.TITLE" => $data['title'],
      "ORAL.NAME" => $user_data['first_name'] . ' ' . $user_data['last_name'],
    ));
    
    $i++;
   
  } 
}
  

/* Are there any oral presnetations yet? */
if ($i == 1) {
  
  $orals_not_found = true;
  
} else {

  /* Parse oral presentations */
  $tpl->parseLoop('ORAL');

}



/* Get all contributed papers */
$result = $subForm->getPapers();


/* Display poster presentations */
$i = 1;
while ($data = mysqli_fetch_array($result)) {
    
  /* Assign poster presentations */
  if ($data['type'] == 'poster') {
    
    $user_data = $userAccount->getUserData($data['author']);
  
    $tpl->assignLoop(array(
      "POSTER.TITLE" => $data['title'],
      "POSTER.NAME" => $user_data['first_name'] . ' ' . $user_data['last_name'],
    ));
    
    $i++;
    
  } 
}
  

/* Are there any poster presnetations yet? */
if ($i == 1) {
  
  $posters_not_found = true;
  
} else {

  /* Parse poster presentations */
  $tpl->parseLoop('POSTER');

}


/* Parse the found/not found message */
$tpl->assignIf(array(
    "ORALS_FOUND" => !$orals_not_found,
    "ORALS_NOT_FOUND" => $orals_not_found,
    "POSTERS_FOUND" => !$posters_not_found,
    "POSTERS_NOT_FOUND" => $posters_not_found,
  ));
$tpl->parseIf();


/* Output final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>