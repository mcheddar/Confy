<?php
/********************************/
/* Registration form management */
/********************************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/conference.class.php");
require_once("../includes/regForm.class.php");

/* Intitalize and output header */
initHeader("Registration Form Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the RegForm class, which handles conference's registration form */
$regForm = new RegForm($adminAccount->getCurrentConference());

/* Let's create an instance of the Conference class, which handles operations with currently selected conference */
$conference = new Conference($adminAccount->getCurrentConference());


/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_regform.tpl");


/* Are there any registered participants yet? If yes, show warning message */
if ($regForm->countParticipants() > 0) {

  $msg_warning = true;

}


/* On user's attempt to add a new field */
if (isset($_POST["new_field"])) {

  /* Add field to the database */
  $regForm->addField($_POST["type"], $_POST["after"]);
    
  header('Location: conference_regform_edit.php');
      
}


/* On user's attempt to delete a form field */
if (isset($_POST["delete_field"])) {

  /* Delete that item */
  $regForm->deleteField($_POST["delete_field"]);
  
  /* Show user a success message */
  $msg_delete_success = true;
  
}


/* On user's attempt to move a field */
if (isset($_POST["move_field"])) {

  if ($_POST['direction'] == 'up') {
    $regForm->moveUp($_POST["move_field"]);
  }
  
  if ($_POST['direction'] == 'down') {
    $regForm->moveDown($_POST["move_field"]);
  }

}


/* On user's attempt to save registration notes */
if (isset($_POST["edit_regform_notes"])) {

  /* Save notes to the database */
  $regForm->editNotes($_POST["regform_notes"]);
  
  /* Show user a success message */
  $msg_notes_success = true;
 
}


/* Lets assign each field's data to the template file */
$result = $regForm->getAllFields();
$i = 1;
while ($data = mysqli_fetch_array($result)) {

  /* If even iteration, we need to display different style of table */
  if ($i % 2 == 0) {
    $even = ' class="even"';
  } else {
    $even = '';
  }
  
  /* If we're dealing with an e-mail or last_name field, deleting and editing is restricted */
  if (($data['db_column'] == 'email') || ($data['db_column'] == 'last_name')) {
    $delete_disabled = true;
  } else {
    $delete_disabled = false;
  }
  
  if ($data['type'] == 'title') {
    
    $data['caption'] = '<br /><br /><b>' . $data['caption'] . '</b>';
    $form_output = '';
    
  } else if ($data['type'] == 'text') {
  
    $form_output = '<input type="text" size="40" />';
  
  } else if ($data['type'] == 'password') {
  
    $form_output = '<input type="password" size="20" />';
  
  } else if ($data['type'] == 'textarea') {
  
    $form_output = '<textarea rows="5" cols="40"></textarea>';
  
  } else if (($data['type'] == 'radio') || ($data['type'] == 'checkbox')) {
  
    $options = explode(',', $data['options']);
    foreach ($options as $j => $option) {
    
      $form_output = $form_output . '<input type="' . $data['type'] . '" id="' . $j . '" /><label for="' . $j . '"> ' . $option . '</label>';
      
      if (($data['display'] == 'row') && ($j < sizeof($options))) {
      
        $form_output = $form_output . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      
      } else if (($data['display'] == 'column') && ($j < sizeof($options))) {
      
        $form_output = $form_output . '<br />';
        
      }
    
    }
  
  } else if ($data['type'] == 'country_select') {
  
    $form_output = countrySelect();
  
  }

  /* Assign data for the loop */
  $tpl->assignLoop(array(
    "FIELDS.ID" => $data['id'],
    "FIELDS.CAPTION" => $data['caption'],
    "FIELDS.FORM" => $form_output,
    "FIELDS.DB_COLUMN" => $data['db_column'],
    "FIELDS.EVEN" => $even,
  ));
  
  
  /* Is this field the first one in the form order? */
  $field_first = $regForm->isFirst($data['id']);

  /* Is this field the last one in the form order? */
  $field_last = $regForm->isLast($data['id']);
  
  
  /* Assign these Ifs, handling disabled delete, edit, down and up buttons */
  $tpl->assignIf(array(
    "DELETE_DISABLED_". $data['id'] => $delete_disabled,
    "DELETE_ENABLED_". $data['id'] => !$delete_disabled,
    "EDIT_DISABLED_". $data['id'] => $delete_disabled,
    "EDIT_ENABLED_". $data['id'] => !$delete_disabled,
    "ARROW_UP_DISABLED_". $data['id'] => $field_first,
    "ARROW_UP_ENABLED_". $data['id'] => !$field_first,
    "ARROW_DOWN_DISABLED_". $data['id'] => $field_last,
    "ARROW_DOWN_ENABLED_". $data['id'] => !$field_last,
  ));
  
  $i++;
  unset($options);
  unset($form_output);

}

$tpl->parseLoop('FIELDS');
$tpl->parseIf();


/* Create a drop down selector of all form fields */
$result = $regForm->getAllFields();
while ($data = mysqli_fetch_array($result)) {
  
  /* Assign data for the loop */
  $tpl->assignLoop(array(
    "FIELDS_SELECT.ID" => $data['id'],
    "FIELDS_SELECT.CAPTION" => $data['caption'],
  ));

}

/* Parse the selector */
$tpl->parseLoop('FIELDS_SELECT');

/* Parse the warning/success message */  
$tpl->assignIf(array(
    "MSG_DELETE_SUCCESS" => $msg_delete_success,
    "MSG_NOTES_SUCCESS" => $msg_notes_success,
    "MSG_WARNING" => $msg_warning,
  ));
$tpl->parseIf();


/* Get conference's configuration */
$conference_data = $conference->getConfiguration();

/* Assign and parse the registration form notes */
$tpl->assignStr("REGFORM_NOTES", $conference_data['regform_notes']);
$tpl->parseStr();

/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>