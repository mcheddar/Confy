<?php
/*************************************************************/
/* The class handles emails and messages shown to the user   */
/*************************************************************/ 

require_once('db.class.php');
require_once('conference.class.php');
require_once('userAccount.class.php');
require_once('regForm.class.php');
require_once('fpdf/fpdf.php');
require_once('functions.php');


class Messages {

  public $db;
  public $url;
  
  
  /* Connects to the database and assigns URL of current conference page */
  public function Messages($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
  
  }
  
  
    
  /* Gets all messages from the database */
  public function getMessages() {
  
    /* Get all messages from the configuration table */
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_configuration WHERE (setting LIKE 'email_%') OR (setting LIKE 'msg_%') ");
    
    /* Insert messages into the array */
    while ($data = mysqli_fetch_array($result)) {
    
      $messages[$data['setting']] = $data['value'];
    
    }
    
    return $messages;
  
  }
  
  
  /* Updates all messages in the database */
  public function setMessages($messages) {
    
    /* Update each message */
    foreach($messages as $setting => $value) {
    
      $this->db->query("UPDATE confy_" . $this->url . "_configuration SET value = '" . $value . "' WHERE setting = '$setting'");
    
    }
  
  }
  
  
  /* Generates a PDF file with Registration Overview table */
  private function generatePDF($id) {
  
    /* New instance of FPDF class */
    $pdf = new FPDF();
    
    /* Get conference's configuration data */
    $config = Conference::getConfiguration();
    
    /* Add a new page */
    $pdf->AddPage();
    
    /* Logo */
    $logo_path = 'conferences/' . $this->url . '/images/logo.jpg';
    
    /* Get the height of the logo */
    $size = GetImageSize($logo_path);
    $multiplier = $size[0] / 215;
    $height = (($size[1] / $multiplier) / 5) + 15;
    
    /* Output logo */
    $pdf->Image($logo_path, 10, 5, 70);
    
    
    $pdf->Ln(-20+$height);
    /* Name of the event */
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,55,iconv('UTF-8', 'windows-1252', $config['name']),0,0);
    $pdf->Ln(20);
    
    /* Subtitle of the event */
    $pdf->SetFont('Arial','I',11);
    $pdf->Cell(0,30,iconv('UTF-8', 'windows-1252', $config['name_subtitle']),0,0);
    
    /* Line */
    $pdf->Line(10, 30+$height, 200, 30+$height);
    $pdf->Ln(30);
    
    /* Title */
    $pdf->SetFont('Arial','BI',14);
    $pdf->Cell(100,5,'Registration Overview',0,0);
    $pdf->Ln(10);
    
    /* Get user's data */
    $user_data = UserAccount::getUserData($id);
    
    /* Get registration form's data from the database */
    $result = RegForm::getAllFields();
    
    /* Now roll through all fields and print the data */
    while ($data = mysqli_fetch_array($result)) {
    
      /* We don't need to print titles titles */
      if ($data['type'] != 'title') {
      
        /* Convert country code to country name */
        if ($data['type'] == 'country_select') {
          $user_data[$data['db_column']] = convertCountry($user_data[$data['db_column']]);
        }
        
        /* Print all values which are not empty */
        if (!empty($user_data[$data['db_column']])) {
            
          $pdf->SetFont('Arial','B',11);
          $pdf->Cell(60,6,(iconv('UTF-8', 'windows-1252', RegForm::getCaption($data['db_column'])) . ': '),0,0,"R");
          $pdf->SetFont('Arial','',11);
          $pdf->Cell(100,6,iconv('UTF-8', 'windows-1252', $user_data[$data['db_column']]),0,1);
          
        } 
      }
    }
    
    /* Return PDF */
    return $pdf->Output("", "S");
    
  }
  
  private function convertTags($str) {
  
    /* Get conference's configuration data */
    $config = Conference::getConfiguration();
  
    $str = preg_replace("/{PAGE_TITLE}/", $config['page_title'], $str);
    $str = preg_replace("/{CONFERENCE_FULL_NAME}/", $config['name'], $str);
    $str = preg_replace("/{REGISTRATION_DEADLINE}/", date("F jS, Y, H:i", $config['deadline_registration']), $str);
    $str = preg_replace("/{SUBMISSION_DEADLINE}/", date("F jS, Y, H:i", $config['deadline_submission']), $str);
    
    $str = nl2br($str);
    $str = stripslashes($str);
    
    return $str;
  }
  
  
  private function convertTagsUser($str, $email, $password) {

    $str = preg_replace("/{USER_EMAIL}/", $email, $str);
    $str = preg_replace("/{USER_PASSWORD}/", $password, $str);

    return $str;
  }  
  
  
  private function convertTagsPaper($str, $paper_type, $paper_topic, $paper_title) {

    $str = preg_replace("/{PAPER_TYPE}/", $paper_type, $str);
    $str = preg_replace("/{PAPER_TOPIC}/", $paper_topic, $str);
    $str = preg_replace("/{PAPER_TITLE}/", $paper_title, $str);

    return $str;
  }  
  
  
  /* Returns a message for the user after successful registration */
  public function newRegistrationMsg() {

    /* Get all messages */
    $messages = $this->getMessages();
    
    return $this->convertTags($messages['msg_new_registration']);

  }
  
  
  /* Sends a confirmation e-mail to the user with his password. In the attachment is confirmation PDF file */
  public function newRegistration($id, $password) {

    /* Get user's data */
    $data = UserAccount::getUserData($id);
    
    /* Get conference's configuration data */
    $config = Conference::getConfiguration();

    /* Get all messages */
    $messages = $this->getMessages();
    
    /* Convert standard tags */
    $subject = $this->convertTags($messages['email_new_registration_subject']);
    $text = $this->convertTags($messages['email_new_registration_text']);
    
    /* Convert email & password tags */
    $text = $this->convertTagsUser($text, $data['email'], $password);
    
    /* Generate confirmation PDF */
    $pdf = $this->generatePDF($id);
    $pdf_name = "registration-overview-" . removeDiacritics($data['last_name']) . ".pdf";
    
    /* Send e-mail to user */
    email($data['email'], $config['conference_email'], $config['page_title'], $subject, $text, $pdf, $pdf_name);
    
    /* Send e-mail to admin */
    $subject = $subject . '[' . $data['first_name'] . ' ' . $data['last_name'] . ']';
    email($config['conference_email'], $config['conference_email'], $config['page_title'], $subject, $text, $pdf, $pdf_name);
  
  }
  
  
  /* Sends a confirmation e-mail when user reviewed his information */
  public function changeRegistration($id) {

    /* Get user's data */
    $data = UserAccount::getUserData($id);     
    
    /* Get conference's configuration data */
    $config = Conference::getConfiguration();
    
    /* Get all messages */
    $messages = $this->getMessages();
    
    /* Convert standard tags */
    $subject = $this->convertTags($messages['email_change_registration_subject']);
    $text = $this->convertTags($messages['email_change_registration_text']);
    
    /* Generate confirmation PDF */
    $pdf = $this->generatePDF($id);
    $pdf_name = "registration-overview-" . removeDiacritics($data['last_name']) . ".pdf";
    
    /* Send e-mail to user */
    email($data['email'], $config['conference_email'], $config['page_title'], $subject, $text, $pdf, $pdf_name);
    
    /* Send e-mail to admin */
    $subject = $subject . ' [' . $data['first_name'] . ' ' . $data['last_name'] . ']';
    email($config['conference_email'], $config['conference_email'], $config['page_title'], $subject, $text, $pdf, $pdf_name);
  
  }
  
  
  /* Sends an e-mail to the user with his new password. */
  public function resetPassword($id, $password) {

    /* Get user's data */
    $data = UserAccount::getUserData($id);
    
    /* Get conference's configuration data */
    $config = Conference::getConfiguration();
    
    /* Get all messages */
    $messages = $this->getMessages();
    
    /* Convert standard tags */
    $subject = $this->convertTags($messages['email_new_password_subject']);
    $text = $this->convertTags($messages['email_new_password_text']);
    
    /* Convert email & password tags */
    $text = $this->convertTagsUser($text, $data['email'], $password);
    
    /* Send e-mail to user */
    email($data['email'], $config['conference_email'], $config['page_title'], $subject, $text);
    
    /* Send e-mail to admin */
    $subject = $subject . ' [' . $data['first_name'] . ' ' . $data['last_name'] . ']';
    email($config['conference_email'], $config['conference_email'], $config['page_title'], $subject, $text);
  
  }
  
  
  /* Sends a confirmation e-mail to the user about his new contribution */
  public function newPaper($id, $paper_type, $paper_topic, $paper_title) {

    /* Get user's data */
    $data = UserAccount::getUserData($id);
    
    /* Get conference's configuration data */
    $config = Conference::getConfiguration();
    
    /* Get all messages */
    $messages = $this->getMessages();
    
    /* Convert standard tags */
    $subject = $this->convertTags($messages['email_new_contribution_subject']);
    $text = $this->convertTags($messages['email_new_contribution_text']);
    
    /* Convert paper tags */
    $text = $this->convertTagsPaper($text, $paper_type, $paper_topic, $paper_title);
    
    /* Send e-mail to user */
    email($data['email'], $config['conference_email'], $config['page_title'], $subject, $text);
    
    /* Send e-mail to admin */
    $subject = $subject . ' [' . $data['first_name'] . ' ' . $data['last_name'] . ']';
    email($config['conference_email'], $config['conference_email'], $config['page_title'], $subject, $text);
  
  }
  
  
  /* Sends a confirmation e-mail to the user about paper deletion */
  public function deletePaper($id, $paper_type, $paper_topic, $paper_title) {

    /* Get user's data */
    $data = UserAccount::getUserData($id);
    
    /* Get conference's configuration data */
    $config = Conference::getConfiguration();
    
    /* Get all messages */
    $messages = $this->getMessages();
    
    /* Convert standard tags */
    $subject = $this->convertTags($messages['email_delete_contribution_subject']);
    $text = $this->convertTags($messages['email_delete_contribution_text']);
    
    /* Convert paper tags */
    $text = $this->convertTagsPaper($text, $paper_type, $paper_topic, $paper_title);
    
    /* Send e-mail to user */
    email($data['email'], $config['conference_email'], $config['page_title'], $subject, $text);
    
    /* Send e-mail to admin */
    $subject = $subject . ' [' . $data['first_name'] . ' ' . $data['last_name'] . ']';
    email($config['conference_email'], $config['conference_email'], $config['page_title'], $subject, $text);
  
  }
  
}

?>