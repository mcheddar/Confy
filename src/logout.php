<?php
/*********************/
/* User Log out page */
/*********************/


require_once("includes/userAccount.class.php");

/* Lets create an instance of the UserAccount class, which handles user's account */
$userAccount = new UserAccount($_GET['conf']);

/* Log out the user */
$userAccount->logOut();

/* Redirect to the home page */
header('Location: home.html'); 

?>