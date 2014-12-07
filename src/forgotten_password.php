<?php
/***********************/
/* Password Reset Form */
/***********************/


require_once("includes/init.php");
require_once("includes/userAccount.class.php");

/* Intitalize and output header */
initHeader("Forgotten Password");

/* Let's create an instance of the UserAccount class, which handles all operations with User's account */
$userAccount = new UserAccount($_GET['conf']);

/* Initialize page's template file */
$tpl = new Template("templates/default/forgotten_password.tpl");  


/* On user's attempt to reset password */
if (isset($_POST["reset_pass"])) {
  
  /* Verify entered password */
  if ($userAccount->resetPassword($_POST["email"])) {
      
    $reset_ok = true;
    
  } else {
    
    $err_wrong_email = true;

  }
}    

if (!$reset_ok) {

  $tpl->assignStr("INPUT_EMAIL", $_POST["email"]);

  /* Parse the error message */  
  $tpl->assignIf("ERR_WRONG_EMAIL", $err_wrong_email);
  $tpl->parseIf();

}

/* Display the reset form or display the success message */
$tpl->assignIf(array(
      "RESET_FORM" => !$reset_ok,
      "RESET_OK" => $reset_ok,
    ));
$tpl->parseIf();


/* Parse and output HTML code of this page */
$tpl->parseStr();
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>