<?php
/********************************************************************/
/* The class handles basic operations with specific conference web  */
/********************************************************************/ 

require_once('db.class.php');

class Conference {

  public $db;
  public $url;
  
  
  /* Connects to the database and assigns URL of current conference web */
  public function Conference($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
  
  }
  
  
  /* Returns an array of general configuration data */
  public function getConfiguration() {
    
    /* Get all the configuration data */
    $query = $this->db->query("SELECT * FROM confy_" . $this->url . "_configuration");
    
    /* Load configuration data to an array */
    while ($data = mysqli_fetch_array($query)) {
      $result[$data['setting']] = $data['value'];
    }
    
    return $result;
    
  }
  
  
  /* Updates configuration data in database */
  public function setConfiguration($data) {
  
    /* Add some backslashes before trublesome characters */
    $data = arrayAddslashes($data);
    
    /* Update each setting in database */
    foreach ($data as $setting => $value) {

      $this->db->query("UPDATE confy_" . $this->url . "_configuration
                        SET value = '" . $value . "' 
                        WHERE setting = '" . $setting . "'");
    
    }
    
  }
  
  
  /* Sends a mass e-mail message. */
  public function sendMassEmail($subject, $text, $file, $list = false) {

    /* Get conference's configuration data */
    $config = Conference::getConfiguration();
    
    /* Convert new lines to <br /> */
    $text = nl2br($text);
    
    /* Strip slashes */
    $subject = stripslashes($subject);
    $text = stripslashes($text);
    
    /* Check if there is any attachment selected */
    if (!empty($file['name'])) {
    
      /* Upload the file to the root directory */
      uploadFile($file, $file['name'], '../');
    
    }

    /* If no list of recipients is provided, send message to all registered participants */
    if (!$list) {
    
      /* Get all users' data */
      $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_participants");
      
      while ($data = mysqli_fetch_array($result)) {
      
        /* Send email with no attachment */
        if (empty($file['name'])) {
          
          email($data['email'], $config['conference_email'], $config['page_title'], $subject, $text);
          
        } else {
        
          email($data['email'], $config['conference_email'], $config['page_title'], $subject, $text, file_get_contents('../'.$file['name']), $file['name']);

        }
      
      }
    
    } else {
    
      /* Explode the list to an array */
      $emails = explode("\n", $list);
      
      /* Send email to each e-mail address */
      foreach($emails as $i => $address) {
      
        /* Remove blank characters */
        $address = trim($address);
      
        /* Check if the address is valid */
        if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
          
          /* Send email with no attachment */
          if (empty($file['name'])) {
          
            email($address, $config['conference_email'], $config['page_title'], $subject, $text);
          
          /* Send email with attachment */
          } else {
          
            email($address, $config['conference_email'], $config['page_title'], $subject, $text, file_get_contents('../'.$file['name']), $file['name']);

          }
        
        } else {
        
          echo "Error while sendind e-mail to ". $address . '<br>';
        
        }
      
      }

    }
    
    /* If there was any attachment, delete it from the server */
    if (!empty($file['name'])) {
    
      /* Delete file from the server */
      unlink('../'.$file['name']);  
    
    }
    
  }
  
}

?>