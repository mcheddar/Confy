<?php
/**************************/
/* Admnistration Settings */
/**************************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");

/* Intitalize and output header */
initHeader("Settings");

/* Initialize page's template file */
$tpl = new Template("../templates/admin/settings.tpl");  

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();


/* On user's attempt to change password */
if (isset($_POST["change_password"])) {
  
  /* Is the old password valid? */
  if (!$adminAccount->verifyPassword($_POST["password_old"])) {
    $err_password_invalid = true;
  }
  
  /* Check if user confirmed the new password correctly */
  if ($_POST["password_new"] != $_POST["password_new_2"]) {
    $err_password_different = true;
  }
  
  /* New password must be at least 6 characters long */
  if (strlen($_POST["password_new"]) < 6) {
    $err_password_short = true;
  }
  
  /* If there were no errors, change the password */
  if (!$err_password_invalid &&
      !$err_password_different &&
      !$err_password_short) {
  
    $adminAccount->changePassword($_POST["password_new"]);
    $msg_change_success = true;
      
  }
}

/* Parse the error/success message(s) */
$tpl->assignIf(array(
    "ERR_PASSWORD_INVALID" => $err_password_invalid,
    "ERR_PASSWORD_DIFFERENT" => $err_password_different,
    "ERR_PASSWORD_SHORT" => $err_password_short,
    "MSG_CHANGE_SUCCESS" => $msg_change_success,
  ));
$tpl->parseIf();

/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>