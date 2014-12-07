<?php
/****************************/
/* Online registration form */
/****************************/

require_once("includes/regForm.class.php");
require_once("includes/userAccount.class.php");
require_once("includes/conference.class.php");
require_once("includes/messages.class.php");
require_once("includes/init.php");

/* Let's create an instance of the UserAccount class, which handles operations with user's account */
$userAccount = new UserAccount($_GET['conf']);

/* If user is logged in, switch automatically to the edit mode */
if ($userAccount->isLogged()) {
  $_GET["action"] = 'edit';
  initHeader("Review Registration", true);
} else {
  unset($_GET["action"]);
  initHeader("Online Registration");
}


/* Initialize page's template file */
$tpl = new Template("templates/default/registration.tpl"); 

/* Let's create an instance of the RegForm class, which handles conference's registration form */
$regForm = new RegForm($_GET['conf']);

/* Let's create an instance of the Messages class, which handles messages shown to the user */
$messages = new Messages($_GET['conf']);

/* Let's create an instance of the Conference class, which handles operations with currently selected conference */
$conference = new Conference($_GET['conf']);

/* Get conference's configuration */
$conference_data = $conference->getConfiguration();

/* Is registration open? */
if ($conference_data['deadline_registration'] >= time()) {
  $registration_open = true;
} else {
  $registration_closed = true;
}



/* Is this an edit mode? */
if (isset($_POST["submit_edit"]) || ($_GET["action"] == 'edit')) {
  $mode_edit = true;
}

if ($registration_open) {

  /* On user's attempt to register */
  if (isset($_POST["submit_register"]) || isset($_POST["submit_edit"])) {
  
    /* Get registration form's data from the database */
    $result = $regForm->getAllFields();
    
    /* Let's roll through all fields in the registration form */
    while ($data = mysqli_fetch_array($result)) {
    
      /* If current field is checkbox, we need to implode the options back to one string */
      if ($data['type'] == 'checkbox') {
      
        /* We start by exploding all possible options */
        $options = explode(',', $data['options']);
        foreach ($options as $j => $option) {
        
          /* And check if there is match with the values posted from the registration form */
          if ($_POST[$data['db_column'] . '-' . $j] == $option) {
          
            /* If there is match, add option to the string */
            $_POST[$data['db_column']] = $_POST[$data['db_column']] . $option . ', ';
          
          }
        }
        
        /* After imploding, we just cut the last 2 characters off the string (it's comma and space, which we don't need) */
        $_POST[$data['db_column']] = substr($_POST[$data['db_column']], 0, -2);
      
      }
    
      /* Now check if current field is required */
      if ($data['required'] == 1) {
      
        /* If the field is missing, assign its Caption to the error messages. Only exception is checkbox field, which may be left empty */
        if ((empty($_POST[$data['db_column']])) && ($data['type'] != 'checkbox')) {
        
          $errors = true;
          $tpl->assignLoop("ERRORS.CAPTION", $data['caption']);
        
        }
      }
      
      /* Get this field's value ready to send to the register method */
      if ($data['type'] != 'title') { 
        $data_to_send[$data['db_column']] = $_POST[$data['db_column']];
      }
    }
    
    /* Now we need to check validity of the e-mail address... */
    if (!filter_var($data_to_send['email'], FILTER_VALIDATE_EMAIL)) {
      $email_invalid = true; 
    }
      
    /* ... and its availability */
    if (!$regForm->checkEmailAvailable($data_to_send['email'], $userAccount->user_id)) {
      $email_not_avail = true;
    }
  
    
    /* If there were any errors, we need to parse error messages, else we can register new participant */
    if ($errors) {
    
      /* Parse error messages */
      $tpl->parseLoop('ERRORS');
    
    } else {
    
      if (!$email_invalid && !$email_not_avail) {
        
        /* Register mode */
        if (isset($_POST["submit_register"])) {
        
          /* Register new participant */
          $register_ok = $userAccount->register($data_to_send);
        
        /* Edit mode */  
        } else {
        
          $userAccount->editUser($data_to_send);
          $msg_edit_success = true;
        
        }
          
      }
    }
  }
  
  /* If registration is not already done, we need to display registration form */
  if (!$register_ok) {
  
    /* If there were some errors, we need to display error messages to the user. Also determine the submit buttons for register/edit mode */
    $tpl->assignIf(array(
        "ERRORS_OCCURED" => $errors,
        "ERROR_EMAIL_INVALID" => $email_invalid,
        "ERROR_EMAIL_NOT_AVAIL" => $email_not_avail,
        "MSG_EDIT_SUCCESS" => $msg_edit_success,
        "MODE_REGISTER_SUBMIT" => !$mode_edit,
        "MODE_EDIT_SUBMIT" => $mode_edit,
      ));
    $tpl->parseIf();
    
    /* If we are in an Edit mode for the first time (no forms were send yet), we need to load the data to the forms */
    if (($_GET["action"] == 'edit') && !isset($_POST["submit_edit"])) {
      $user_data = $userAccount->getUserData();
    } 
    
    
    /* Get registration form's data from the database */
    $result = $regForm->getAllFields();
    
    /* Now roll through all fields and define their HTML output */
    while ($data = mysqli_fetch_array($result)) {
    
      /* Load the logged in user's data to the form if we're in the edit mode */
      if (($_GET["action"] == 'edit') && !isset($_POST["submit_edit"])) {
        $_POST[$data['db_column']] = $user_data[$data['db_column']];
      } 
      
      if ($data['type'] == 'title') {
        
        $data['caption'] = '<br /><br /><b>' . $data['caption'] . '</b>';
        $form_output = '';
        
      } else if ($data['type'] == 'text') {
      
        $form_output = '<input type="text" name="' . $data['db_column'] . '" size="40" value="' . $_POST[$data['db_column']] . '" />';
      
      } else if ($data['type'] == 'password') {
      
        $form_output = '<input type="password" name="password" size="20" />';
      
      } else if ($data['type'] == 'textarea') {
      
        $form_output = '<textarea name="' . $data['db_column'] . '" rows="5" cols="40">' . $_POST[$data['db_column']] . '</textarea>';
      
      } else if (($data['type'] == 'radio') || ($data['type'] == 'checkbox')) {
      
        /* Explode and go throgh all possible options */
        $options = explode(',', $data['options']);
        foreach ($options as $j => $option) {
    
          if ($data['type'] == 'radio') {
          
            if ($_POST[$data['db_column']] == $option) {
              $checked = 'checked="checked" ';
            } else {
              $checked = '';
            }
              
            $form_output = $form_output . '<input type="radio" name="' . $data['db_column'] . '" id="' . $data['db_column'] . '-' . $j . '" value="' . $option . '" ' . $checked . '/><label for="' . $data['db_column'] . '-' . $j . '"> ' . $option . '</label>';
          
          } else if ($data['type'] == 'checkbox') {
          
            if ($_POST[$data['db_column'] . '-' . $j] == $option) {
              $checked = 'checked="checked" ';
            } else {
              $checked = '';
            }
          
            $form_output = $form_output . '<input type="checkbox" name="' . $data['db_column'] . '-' . $j . '" id="' . $data['db_column'] . '-' . $j . '" value="' . $option . '" ' . $checked . '/><label for="' . $data['db_column'] . '-' . $j . '"> ' . $option . '</label>';
          
          }
          
          if (($data['display'] == 'row') && ($j < sizeof($options))) {
          
            $form_output = $form_output . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
          
          } else if (($data['display'] == 'column') && ($j < sizeof($options))) {
          
            $form_output = $form_output . '<br />';
            
          }
        
        }
      
      } else if ($data['type'] == 'country_select') {
      
        $form_output = countrySelect($data['db_column'], $_POST[$data['db_column']]);
      
      }
      
      /* Assign the Required Field Sign */
      $tpl->assignIf("FIELD_REQUIRED_". $data['id'], $data['required']);
    
      /* Assign data for the loop */
      $tpl->assignLoop(array(
        "FIELDS.ID" => $data['id'],
        "FIELDS.CAPTION" => $data['caption'],
        "FIELDS.FORM" => $form_output,
      ));
    
      unset($options);
      unset($form_output);
    
    }
    
    /* Parse all fields */
    $tpl->parseLoop('FIELDS');
    $tpl->parseIf();
    
    /* Display registration notes */
    $tpl->assignStr("REGFORM_NOTES", $conference_data['regform_notes']);

  }
}

/* Display deadline for registration */
$tpl->assignStr("REGISTRATION_DEADLINE", date("F jS, Y, H:i", $conference_data['deadline_registration']));
$tpl->parseStr();


/* Open or closed? Register mode or edit mode? */
$tpl->assignIf(array(
          "REGISTRATION_OPEN" => $registration_open,
          "REGISTRATION_CLOSED" => $registration_closed,
          "MODE_EDIT_H2" => $mode_edit,
          "MODE_REGISTER_H2" => !$mode_edit,
        ));
$tpl->parseIf();



/* If registration is already done, we're gonna display participant's registration overview */
if ($register_ok) {
  
  /* Initialize registration overview template file */
  $tpl = new Template("templates/default/registration_overview.tpl");
    

  /* Go through all entered values and prepare them for registration overview */                   
  foreach ($data_to_send as $db_column => $value) {
    
    /* Show value in overview only if it was entered */
    if (!empty($value)) {
    
      /* Convert country code to country name */
      if ($db_column == 'country') {
        $value = convertCountry($value);
      }
    
      $tpl->assignLoop(array(
        "OVERVIEW.CAPTION" => $regForm->getCaption($db_column),
        "OVERVIEW.DATA" => $value,
      ));
    }
    
  }
    
  $tpl->parseLoop('OVERVIEW');
  
  /* Get the message for user */
  $msg_new_registration = $messages->newRegistrationMsg();
  
  $tpl->assignStr("MSG_NEW_REGISTRATION", $msg_new_registration);
        
  $tpl->parseStr();
  
}
 

/* Output HTML code of this page */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>