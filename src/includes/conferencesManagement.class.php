<?php
/****************************************************************/
/* The class handles basic operations with all Conference pages */
/****************************************************************/ 

require_once('db.class.php');

class ConferencesManagement {

  public $db;
  
  
  /* Connects to the database */
  public function ConferencesManagement() {
  
    $this->db = Db::getInstance();
  
  }
  
  
  /* Creates database tables for the new conference with prefixes same as URL address */
  private function createSQL($url) {
    
    /* Load predefined SQL query with default tables */
    $sql = file_get_contents('../includes/new_conference.sql');
    
    /* Replace the table prefixes */
    $sql = preg_replace("/NEW_CONFERENCE/", $url, $sql);
    
    /* Create SQL tables */
    $this->db->multi_query($sql);

  }
  
  
  /* Creates FTP folder for the conference and copies images from default template */
  private function createFolder($url) {
    
    /* Create folders */
    mkdir("../conferences/" . $url, 0700);
    mkdir("../conferences/" . $url . "/images", 0700);
    
    /* Set a list of images to copy */
    $images = array(
        "logo.jpg",
        "panorama.jpg",
        "bcg.png",
        "favicon.ico",
    );
    
    /* Copy each image to the new folder */
    foreach ($images as $i => $filename) {
    
      copy("../templates/default/images/" . $filename, "../conferences/" . $url . "/images/" . $filename);
    
    }

  }
  

  /* Checks if the given URL is valid */
  public function checkUrlValid($url) {
  
    /* The only allowed characters in URL are 0-9, A-Z, a-z, - */
    return !preg_match('/[^0-9A-Za-z-]/', $url);          
                       
  }
  
  
  /* Checks if the given URL is available */
  public function checkUrlAvailable($url) {
  
    /* These URLs are not allowed because they are already in use by Confy as a system folders */
    if ($url == 'admin' || $url == 'conferences' || $url == 'includes' || $url == 'templates') {
      return false; 
    }
    
    /* Search for the same URL in existing conferences */
    $query = $this->db->query("SELECT id FROM confy_admin_conferences 
                               WHERE url = '" . $url . "'");
    
    /* If there is 0 matches, URL is available */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }         
                       
  }
  
  
  /* Checks if the URL's length is OK */
  public function checkUrlLength($url) {
  
    if (strlen($url) >= 1 && strlen($url) <= 30) {
      return true;
    } else {
      return false;
    }    
                       
  }
  
  
  /* Creates a new conference page */
  public function createNewConference($url) {
    
    $this->db->query("INSERT INTO confy_admin_conferences (id, url)
                               VALUES ('', '" . $url . "')");
  
    /* Create database tables for the new conference */                           
    $this->createSQL($url);
    
    /* Create folder and copy default images */
    $this->createFolder($url);
   
  }
  
  
  /* Returns an array of titles of all the existing conferences */
  public function getConferences() {
  
    $query = $this->db->query("SELECT * FROM confy_admin_conferences ORDER BY id DESC");
    
    while ($data = mysqli_fetch_array($query)) {
      $query_name = $this->db->query("SELECT value FROM confy_" . $data['url'] . "_configuration WHERE setting = 'page_title'");
      $data_name = mysqli_fetch_array($query_name);
      $result[$data['url']] = $data_name['value'];
    }
    
    return $result;
                                              
  }

}

?>