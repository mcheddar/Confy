<?php
/******************************************************/
/* The class handles changes to webpage's appearance  */
/******************************************************/ 

require_once('db.class.php');

class Appearance {

  public $db;
  public $url;
  
  
  /* Connects to the database and assigns URL of current conference web */
  public function Appearance($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
  
  }
  
  
  /* Uploads image to conference's images folder */
  public function uploadImage($image, $filename) {
  
    return uploadFile($image, $filename, "../conferences/" . $this->url . "/images/");
    
  }
  
  
  /* Gets a set of colors for CSS file from the database */
  public function getColors() {
  
    /* Get all apparance setting from the configuration table */
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_configuration WHERE setting LIKE 'app_%'");
    
    /* Insert colors into the array */
    while ($data = mysqli_fetch_array($result)) {
    
      $colors[$data['setting']] = $data['value'];
    
    }
    
    return $colors;
  
  }
  
  
  /* Updates a set of colors for CSS file in the database */
  public function setColors($colors) {
    
    /* Update each color */
    foreach($colors as $setting => $value) {
    
      $this->db->query("UPDATE confy_" . $this->url . "_configuration SET value = '" . $value . "' WHERE setting = '$setting'");
    
    }
  
  }
  
  
  
}

?>