<?php
/******************************/
/* Admnistration Log out page */
/******************************/


require_once("../includes/adminAccount.class.php");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Log out the administrator */
$adminAccount->logOut();

/* Redirect to the log in page */
header('Location: login.php'); 

?>