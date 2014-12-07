<?php
/********************************************************/
/* The class handles operations with conference's menu  */
/********************************************************/ 

require_once('db.class.php');

class Menu {

  public $db;
  public $url;
  
  
  /* Connects to the database and assigns URL of current conference page */
  public function Menu($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
  
  }
  
  
  
  /* Converts special pages' links to nicer captions */
  public function convertSpecialLink($link) {
  
    switch ($link) {
      case 'home':
          return 'Home Page';
      case 'registration-form':
          return 'Registration Form';
      case 'participants':
          return 'List of Registered Participants';
      case 'submitted-papers':
          return 'List of Submitted Papers';
      }
  
  }
  
  
  /* Finds out if item is the first one in the menu order */
  public function isFirst($id) {
  
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_menu 
                               WHERE id < '" . $id . "'");
                               
    /* If there is 0 matches, item is first */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }
    
  }
  
  
  /* Finds out if item is the last one in the menu order */
  public function isLast($id) {
  
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_menu 
                               WHERE id > '" . $id . "'");
                               
    /* If there is 0 matches, item is last */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }
    
  }
  
  
  /* Returns all of the menu items */
  public function getAllItems() {
  
    /* Get items' data */
    return $this->db->query("SELECT * FROM confy_" . $this->url . "_menu ORDER BY id ASC");
  
  }
  
  
  /* Returns one menu item */
  public function getItem($id) {
  
    /* Get items' data */
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_menu WHERE id = '" . $id . "'");
    return mysqli_fetch_array($result);
  
  }
  
  
  /* Returns the next visible item after given ID */
  public function getNextVisible($id) {
  
    /* Get items' data */
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_menu WHERE id > '" . $id . "' AND hidden = 0 ORDER BY id ASC");
    return mysqli_fetch_array($result);
  
  }
  
  
  
  /* Creates a new menu item */
  public function addItem($caption, $link, $type, $after) {
  
    /* First, we need to increment IDs of all items that occur after this item (so we have some "space" to put this new item in) */
    $this->db->query("UPDATE confy_" . $this->url . "_menu
                      SET id = id + 1
                      WHERE id > '" . $after . "'");
    
    /* Put the new item in the space we created */                           
    $this->db->query("INSERT INTO confy_" . $this->url . "_menu (id, subitem, special, link, caption, hidden)
                      VALUES ('" . $after . "'+1, '" . $type . "', 0, '" . $link . "', '" . $caption . "', 0)"); 

  }
  
  
  /* Deletes a menu item from the database */
  public function deleteItem($id) {
  
    /* First, delete item from the database */
    $this->db->query("DELETE FROM confy_" . $this->url . "_menu 
                      WHERE id = '" . $id . "'");
                      
    /* Reorder IDs of items which were after the deleted item */
    $this->db->query("UPDATE confy_" . $this->url . "_menu
                      SET id = id - 1
                      WHERE id > '" . $id . "'");   
  
  }
  
  
  /* Hides a menu item */
  public function hideItem($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_menu
                      SET hidden = 1
                      WHERE id = '" . $id . "'");
  
  }
  
  
  /* Unhides a menu item */
  public function unhideItem($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_menu
                      SET hidden = 0
                      WHERE id = '" . $id . "'");
  
  }
  
  
  /* Moves an item down */
  public function moveDown($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET id = 0 WHERE id = '" . $id . "'");
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET id = '" . $id . "' WHERE id = '" . $id . "'+1");
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET id = '" . $id . "'+1 WHERE id = 0");
    
    /* We have to make sure the first item in menu is Main Item, not Subitem */
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET subitem = 0 WHERE id = 1");  
  
  }
  
  
  /* Moves an item up */
  public function moveUp($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET id = 0 WHERE id = '" . $id . "'");
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET id = '" . $id . "' WHERE id = '" . $id . "'-1");
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET id = '" . $id . "'-1 WHERE id = 0");
    
    /* We have to make sure the first item in menu is Main Item, not Subitem */
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET subitem = 0 WHERE id = 1");
  
  }
  
  
  /* Sets item as Main Item */
  public function setAsMain($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET subitem = 0 WHERE id = '" . $id . "'");
  
  }
  
  /* Sets item as Subitem */
  public function setAsSub($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_menu SET subitem = 1 WHERE id = '" . $id . "'");
  
  }
  

  
  /* Changes a item's data */
  public function editItem($id, $caption, $link) {
  
    /* If link is provided, we're dealing with a normal page */
    if ($link != '') {
    
      $this->db->query("UPDATE confy_" . $this->url . "_menu 
                        SET caption = '" . $caption . "', link = '" . $link . "'
                        WHERE id = '" . $id . "'");
    
    /* If link is not provided, we're dealing with a special page, so we cannot edit the link */                     
    } else {
    
      $this->db->query("UPDATE confy_" . $this->url . "_menu 
                        SET caption = '" . $caption . "'
                        WHERE id = '" . $id . "'");
                        
    }
  
  }

}

?>