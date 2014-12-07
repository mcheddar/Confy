<?php
/*********************/
/* Form field editing */
/*********************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/regForm.class.php");

/* Intitalize and output header */
initHeader("Registration Form Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the RegForm class, which handles conference's registration form */
$regForm = new RegForm($adminAccount->getCurrentConference()); 


/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_regform_edit.tpl");


/* If ID is not set, we're gonna edit the most recently added field */
if (!isset($_GET['id'])) {

  $_GET['id'] = $regForm->getRecentField();

}

/* Get the field's data */
$data = $regForm->getField($_GET['id']);

/* On user's attempt to save changes to the menu item */
if (isset($_POST["edit_field"])) {
  
  /* Check if Field Caption is entered */
  $err_field_caption = empty($_POST["caption"]);
  
  /* If this field is not a Title, check also a DB Column value */
  if ($data['type'] != 'title') {
    $err_db_column = empty($_POST["db_column"]);
    $err_db_not_avail = !$regForm->checkColumnAvailable($_POST["db_column"], $_GET['id']);
    $err_db_not_valid = !$regForm->checkColumnValid($_POST["db_column"]);
  }
  
  /* If this field is a radio button or checkbox, check also if Options are antered */
  if (($data['type'] == 'radio') || ($data['type'] == 'checkbox')) {
    $err_possible_options = empty($_POST["options"]);
  }

  /* If all the required forms are entered, edit the form field */
  if ( !$err_field_caption &&
       !$err_db_column &&
       !$err_db_not_avail &&
       !$err_db_not_valid &&
       !$err_possible_options ) {

    /* Edit this field */
    $regForm->editField($_GET['id'], $data['type'], $_POST["caption"], $data["db_column"], $_POST["db_column"], $_POST["options"], $_POST["display"], $_POST["required"]);
    
    /* Redirect user back to Registration Form Management page */
    header('Location: conference_regform.php');
      
  }
  
} else {

  $_POST = $data;

}


/* Determine what type of field user is currently editing */
if ($data['type'] == 'title') $type_name = 'Title';
if ($data['type'] == 'text') $type_name = 'Text field';
if ($data['type'] == 'radio') $type_name = 'Radio buttons';
if ($data['type'] == 'checkbox') $type_name = 'Checkboxes';
if ($data['type'] == 'country_select') $type_name = 'Country selection drop-down box';
if ($data['type'] == 'textarea') $type_name = 'Textarea';

/* Give back the entered value to the form */
$tpl->assignStr(array(
      "INPUT_CAPTION" => $_POST["caption"],
      "TYPE_NAME" => $type_name,
    )); 

/* If this is not a Title, give back also a db_column value and dependency selector */
if ($data['type'] != 'title') {

  $tpl->assignStr("INPUT_DB_COLUMN", $_POST["db_column"]);
  $type_not_title = true;
  
  /* Let's check selected radio button about dependency */
  if ($_POST['required'] == '1') {
  
    $opt_checked = '';
    $req_checked = ' checked="checked"';
    
  } else {
  
    $opt_checked = ' checked="checked"';
    $req_checked = '';
  
  }
  
  $tpl->assignStr(array(
      "DEPENDENCY_OPT_CHECKED" => $opt_checked,
      "DEPENDENCY_REQ_CHECKED" => $req_checked,
    )); 
  
}

/* If this is a radio button or checkbox form, assign also the options field and row/column display selector */
if (($data['type'] == 'radio') || ($data['type'] == 'checkbox')) {

  $tpl->assignStr("INPUT_OPTIONS", $_POST["options"]);
  $type_check_radio = true;
  
  /* Let's check selected radio button about display options */
  if ($_POST['display'] == 'column') {
  
    $row_checked = '';
    $col_checked = ' checked="checked"';
    
  } else {
  
    $row_checked = ' checked="checked"';
    $col_checked = '';
  
  }
  
  $tpl->assignStr(array(
      "DISPLAY_ROW_CHECKED" => $row_checked,
      "DISPLAY_COL_CHECKED" => $col_checked,
    )); 
  
}

/* Assign these Ifs */
$tpl->assignIf(array(
    "TYPE_NOT_TITLE_1" => $type_not_title,
    "TYPE_NOT_TITLE_2" => $type_not_title,
    "TYPE_CHECK_RADIO" => $type_check_radio,
  ));

/* Parse Ifs and Strings */
$tpl->parseIf();
$tpl->parseStr();


/* Parse the error/success message(s) */  
$tpl->assignIf(array(
    "ERR_FIELD_CAPTION" => $err_field_caption,
    "ERR_DB_COLUMN" => $err_db_column,
    "ERR_DB_NOT_AVAIL" => $err_db_not_avail,
    "ERR_DB_NOT_VALID" => $err_db_not_valid,
    "ERR_POSSIBLE_OPTIONS" => $err_possible_options,
  ));
$tpl->parseIf();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>