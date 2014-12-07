<?php
/*********************************/
/* Conference Configuration page */
/*********************************/

require_once("../includes/admin_init.php");
require_once("../includes/appearance.class.php");
require_once("../includes/adminAccount.class.php");

/* Intitalize and output header */
initHeader("Appearance");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Conference class, which handles operations with design changes */
$appearance = new Appearance($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_appearance.tpl"); 



/* On user's attempt to upload a logo image */
if (isset($_POST['upload_logo'])) {

  /* Check if a file is selected to upload */
  $err_file_missing = empty($_FILES["file"]["name"]);

  /* Check if the file has allowed file extension */
  if (!$err_file_missing) {
    $err_file_invalid = !(getExtension($_FILES["file"]["name"]) == 'jpg');
  }

  /* If the form is OK, upload a image */
  if (!$err_file_missing && !$err_file_invalid) {
    
    $appearance->uploadImage($_FILES["file"], "logo.jpg");
    
    /* Display confirmation message */
    $msg_success = true;
  
  }

}


/* On user's attempt to upload a panorama image */
if (isset($_POST['upload_panorama'])) {

  /* Check if a file is selected to upload */
  $err_file_missing = empty($_FILES["file"]["name"]);

  /* Check if the file has allowed file extension */
  if (!$err_file_missing) {
    $err_file_invalid = !(getExtension($_FILES["file"]["name"]) == 'jpg');
  }

  /* If the form is OK, upload a image */
  if (!$err_file_missing && !$err_file_invalid) {
    
    $appearance->uploadImage($_FILES["file"], "panorama.jpg");
    
    /* Display confirmation message */
    $msg_success = true;
  
  }

}


/* On user's attempt to upload a background image */
if (isset($_POST['upload_bcg'])) {

  /* Check if a file is selected to upload */
  $err_file_missing = empty($_FILES["file"]["name"]);

  /* Check if the file has allowed file extension */
  if (!$err_file_missing) {
    $err_file_invalid = !(getExtension($_FILES["file"]["name"]) == 'png');
  }

  /* If the form is OK, upload a image */
  if (!$err_file_missing && !$err_file_invalid) {
    
    $appearance->uploadImage($_FILES["file"], "bcg.png");
    
    /* Display confirmation message */
    $msg_success = true;
  
  }

}


/* On user's attempt to upload a favicon */
if (isset($_POST['upload_favicon'])) {

  /* Check if a file is selected to upload */
  $err_file_missing = empty($_FILES["file"]["name"]);

  /* Check if the file has allowed file extension */
  if (!$err_file_missing) {
    $err_file_invalid = !(getExtension($_FILES["file"]["name"]) == 'ico');
  }

  /* If the form is OK, upload a image */
  if (!$err_file_missing && !$err_file_invalid) {
    
    $appearance->uploadImage($_FILES["file"], "favicon.ico");
    
    /* Display confirmation message */
    $msg_success = true;
  
  }

}


/* On user's attempt to update website's colors */
if (isset($_POST['update_colors'])) {

  /* We don't need this value anymore */
  unset ($_POST['update_colors']);
  
  /* Update colors in database */
  $appearance->setColors($_POST);
    
  /* Display confirmation message */
  $msg_success = true;

}


/* Parse the error/success message(s) */ 
$tpl->assignIf(array(
  "ERR_FILE_MISSING" => $err_file_missing,
  "ERR_FILE_INVALID" => $err_file_invalid,  
  "MSG_SUCCESS" => $msg_success, 
)); 
$tpl->parseIf();


/* Assign conference URL */
$tpl->assignStr("CONFERENCE_URL", $adminAccount->getCurrentConference());
$tpl->parseStr();


/* Get all color codes */
$COLORS = $appearance->getColors();

/* Assign the color inputs */
$tpl->assignStr(array(
  "APP_BODY_BACKGROUND" => $COLORS["app_body_background"],
  "APP_BODY_TEXT" => $COLORS["app_body_text"],
  "APP_MAIN_BACKGROUND" => $COLORS["app_main_background"],
  "APP_LINES_TOP" => $COLORS["app_lines_top"],
  "APP_LINES_BOTTOM" => $COLORS["app_lines_bottom"],
  "APP_H2_LINE" => $COLORS["app_h2_line"],
  "APP_A_LINK" => $COLORS["app_a_link"],
  "APP_A_HOVER" => $COLORS["app_a_hover"],
  "APP_TABLE_1" => $COLORS["app_table_1"],
  "APP_TABLE_2" => $COLORS["app_table_2"],
  "APP_TABLE_HEAD" => $COLORS["app_table_head"],
  "APP_TABLE_HEAD_TEXT" => $COLORS["app_table_head_text"],
  "APP_TABLE_BORDER" => $COLORS["app_table_border"],
  "APP_MENU_MAINITEM_BCG" => $COLORS["app_menu_mainitem_bcg"],
  "APP_MENU_MAINITEM_BCG_HOVER" => $COLORS["app_menu_mainitem_bcg_hover"],
  "APP_MENU_MAINITEM_TEXT" => $COLORS["app_menu_mainitem_text"],
  "APP_MENU_MAINITEM_TEXT_HOVER" => $COLORS["app_menu_mainitem_text_hover"],
  "APP_MENU_SUBITEM_BCG" => $COLORS["app_menu_subitem_bcg"],
  "APP_MENU_SUBITEM_BCG_HOVER" => $COLORS["app_menu_subitem_bcg_hover"],
  "APP_MENU_SUBITEM_TEXT" => $COLORS["app_menu_subitem_text"],
  "APP_MENU_SUBITEM_TEXT_HOVER" => $COLORS["app_menu_subitem_text_hover"],
  "APP_MENU_SUBITEM_BORDER" => $COLORS["app_menu_subitem_border"],
)); 
$tpl->parseStr();

/* Output final html code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>