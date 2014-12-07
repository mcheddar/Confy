<?php
/********************/
/* User Log in page */
/********************/

require_once("includes/userAccount.class.php");

/* Let's create an instance of the UserAccount class, which handles all operations with User's account */
$userAccount = new UserAccount($_GET['conf']);

/* If the user is already logged in, redirect to the home page */
if ($userAccount->isLogged() == true) {

  header('Location: home.html'); 

}


require_once("includes/init.php");

/* Intitalize and output header */
initHeader("Log in");

/* Initialize page's template file */
$tpl = new Template("templates/default/login.tpl");  


/* On user's attempt to log in */
if (isset($_POST["login"])) {
  
  /* Verify entered password */
  if ($userAccount->logIn($_POST["email"], $_POST["password"])) {
      
    header('Location: paper-submission.html');
    
  } else {
    
    $err_invalid_password = true;

  }
}    


$tpl->assignStr("INPUT_EMAIL", $_POST["email"]);

/* Parse the error message(s) */  
$tpl->assignIf("ERR_INVALID_PASSWORD", $err_invalid_password);
$tpl->parseIf();


/* Parse and output HTML code of this page */
$tpl->parseStr();
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>