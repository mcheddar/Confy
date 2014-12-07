<?php
/*********************************************************/
/* The class handles operations with conference's pages  */
/*********************************************************/ 

require_once('db.class.php');

class Pages {

  public $db;
  public $url;
  
  
  /* Connects to the database and assigns URL of current conference page */
  public function Pages($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
  
  }
  

  /* Checks if the given URL is available. Second argument is used when we want to exclude URL of specific page from the search */
  public function checkUrlAvailable($url, $id = false) {
    
    /* Search for the same URL in existing pages */
    if ($id == false) {
    
      $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_pages 
                               WHERE url = '" . $url . "'");
    } else {
    
      $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_pages 
                               WHERE url = '" . $url . "' AND id != '" . $id . "'");
    
    }
    
    /* If there is 0 matches, URL is available */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }         
                       
  }
  
  
  /* Returns all conference's pages */
  public function getAllPages() {
  
    /* Get all the pages data */
    return $this->db->query("SELECT id, url, title FROM confy_" . $this->url . "_pages");
  
  }
  
  
  /* Returns array with the data of requested page */
  public function getPage($id) {
  
    /* Get the page's data */
    $result = $this->db->query("SELECT url, title, html FROM confy_" . $this->url . "_pages WHERE id = '" . $id . "'");
    return mysqli_fetch_array($result);
  
  }
  
  
  /* Creates a new page and returns its ID */
  public function addPage($title, $url) {
  
    /* Insert data into database */
    $this->db->query("INSERT INTO confy_" . $this->url . "_pages (id, url, title)
                      VALUES ('', '" . $url . "', '" . $title . "')");
    
    /* Determine and return page's ID */                           
    $query = $this->db->query("SELECT id 
                               FROM confy_" . $this->url . "_pages
                               WHERE url = '" . $url . "'");
                               
    $data = mysqli_fetch_array($query);
    return $data['id'];

  }
  
  
  /* Deletes a page from the database */
  public function deletePage($id) {
  
    $this->db->query("DELETE FROM confy_" . $this->url . "_pages 
                      WHERE id = '" . $id . "'");
  
  }
  
  /* Changes a page's data */
  public function editPage($id, $title, $url, $html) {
  
    $this->db->query("UPDATE confy_" . $this->url . "_pages 
                      SET title = '" . $title . "', url = '" . $url . "', html = '" . $html . "'
                      WHERE id = '" . $id . "'");
  
  }
  
  /* Converts page's URL to its ID */
  public function urlToId($url) {
  
    /* Get requested URL from the database */
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_pages WHERE url = '" . $url . "'");
    $data = mysqli_fetch_array($query);
    return $data['id'];
    
  }

}

?>