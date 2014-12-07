<?php
/*****************************/
/* Admnistration Log in page */
/*****************************/


/* First, we need to include the functions file and some classes */ 
require_once("../includes/functions.php");
require_once("../includes/template.class.php");
require_once("../includes/adminAccount.class.php");

/* Let's create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* If the administrator is already logged in, redirect to the administration home page */
if ($adminAccount->isLogged() == true) {

  header('Location: index.php'); 

}

/* On user's attempt to log in */
if (isset($_POST["login"])) {
  
  /* Verify entered password */
  if ($adminAccount->logIn($_POST["password"])) {
      
    header('Location: index.php');
    
  } else {
    
    $err_invalid_password = true;
    
  }
}


/* Initialize page's template file */
$tpl = new Template("../templates/admin/login.tpl");

/* Parse the error message(s) */  
$tpl->assignIf("ERR_INVALID_PASSWORD", $err_invalid_password);
$tpl->parseIf();

/* Output the final HTML code */
$tpl->output();
?>