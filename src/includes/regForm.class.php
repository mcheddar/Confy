<?php
/***********************************************************/
/* The class handles operations with an registration form  */
/***********************************************************/ 

require_once('db.class.php');

class RegForm {

  public $db;
  public $url;
  
  
  /* Connects to the database and assigns URL of current conference page */
  public function RegForm($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
  
  }
  
  
  /* Creates a new form field */
  public function addField($type, $after) {
  
    /* If this field is not a Title field, we need to create a new column in the Participants table */
    if ($type != 'title') {
    
      /* First, we need to find out what id_primary has the most recently added field */
      $result = $this->db->query("SELECT id_primary FROM confy_" . $this->url . "_regform ORDER BY id_primary DESC");
      $data_primary = mysqli_fetch_array($result);
      
      $db_column = 'new_column_' . ($data_primary['id_primary'] + 1);
      
      /* Now we add a new column to the Participants table */
      $this->db->query("ALTER TABLE `confy_" . $this->url . "_participants` 
                        ADD `" . $db_column . "` TEXT NOT NULL");
      
    }
    
    /* Now we need to increment IDs of all fields that occur after this field (so we have some "space" to put this new field in) */
    $this->db->query("UPDATE confy_" . $this->url . "_regform
                      SET id = id + 1
                      WHERE id > '" . $after . "'");
                      
    
    /* Put the new field in the space we created */                           
    $this->db->query("INSERT INTO confy_" . $this->url . "_regform (id, type, db_column)
                      VALUES ('" . $after . "'+1, '" . $type . "', '" . $db_column . "')"); 

  }
  
  
  /* Updates form field's data */
  public function editField($id, $type, $caption, $db_column_old, $db_column_new = '', $options = '', $display = '', $required = 0) {
  
    /* If this field is not a Title field, we need to change the Participants table */
    if ($type != 'title') {
    
      /* Change the name of the column in Participants table */
      $this->db->query("ALTER TABLE `confy_" . $this->url . "_participants`
                        CHANGE `" . $db_column_old . "` `" . $db_column_new . "` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

    
    }
     echo $values;
    /* Update the RegForm table */
    $this->db->query("UPDATE confy_" . $this->url . "_regform
                      SET db_column = '" . $db_column_new . "', 
                          caption = '" . $caption . "', 
                          options = '" . $options . "', 
                          display = '" . $display . "', 
                          required = '" . $required . "' 
                      WHERE id = '" . $id . "'");
  
  }
  
  
  /* Returns all of the form fields */
  public function getAllFields() {
  
    /* Get fields' data */
    return $this->db->query("SELECT * FROM confy_" . $this->url . "_regform ORDER BY id ASC");
  
  }
  
  
  /* Returns one form field */
  public function getField($id) {
  
    /* Get field's data */
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_regform WHERE id = '" . $id . "'");
    return mysqli_fetch_array($result);
  
  }
  
  
  /* Returns id of the most recently added field */
  public function getRecentField() {
  
    $result = $this->db->query("SELECT id FROM confy_" . $this->url . "_regform ORDER BY id_primary DESC");
    $data = mysqli_fetch_array($result);
    return $data['id'];
  
  }
  
  
  /* Deletes a form field from the database */
  public function deleteField($id) {
  
    /* Get field's db_column */
    $result = $this->db->query("SELECT db_column FROM confy_" . $this->url . "_regform WHERE id = '" . $id . "'");
    $data = mysqli_fetch_array($result);
    
    /* Delete field from the RegForm table */
    $this->db->query("DELETE FROM confy_" . $this->url . "_regform 
                      WHERE id = '" . $id . "'");
                      
    /* Reorder IDs of items which were after the deleted item */
    $this->db->query("UPDATE confy_" . $this->url . "_regform
                      SET id = id - 1
                      WHERE id > '" . $id . "'");
                      
    /* Delete column from the Participants table */
    $this->db->query("ALTER TABLE `confy_" . $this->url . "_participants` DROP `" . $data['db_column'] . "` ");
                      
  }
  
  
  /* Checks if there is no column name mismatch in the participants table */
  public function checkColumnAvailable($db_column, $id) {
  
    /* Search for the same name in existing columns */
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_regform 
                               WHERE db_column = '" . $db_column . "' AND id != '" . $id . "'");
    
  
    /* If there is 0 matches, name is available */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }    
  
  }
  
  
  /* Checks if the given name for DB column is valid */
  public function checkColumnValid($db_column) {
  
    /* The only allowed characters in URL are 0-9, A-Z, a-z, -, _ */
    return !preg_match('/[^0-9A-Za-z-_]/', $db_column);          
                       
  }
  
  
  /* Counts number of registered participants */
  public function countParticipants() {
  
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_participants");
    return mysqli_num_rows($query);
    
  }
  

  /* Finds out if field is the first one in the form order */
  public function isFirst($id) {
  
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_regform 
                               WHERE id < '" . $id . "'");
                               
    /* If there is 0 matches, field is first */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }
    
  }
  
  
  /* Finds out if field is the last one in the form order */
  public function isLast($id) {
  
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_regform 
                               WHERE id > '" . $id . "'");
                               
    /* If there is 0 matches, field is last */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }
    
  }
  
  /* Moves a field down */
  public function moveDown($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_regform SET id = 0 WHERE id = '" . $id . "'");
    $this->db->query("UPDATE confy_" . $this->url . "_regform SET id = '" . $id . "' WHERE id = '" . $id . "'+1");
    $this->db->query("UPDATE confy_" . $this->url . "_regform SET id = '" . $id . "'+1 WHERE id = 0");
  
  }
  
  
  /* Moves a field up */
  public function moveUp($id) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_regform SET id = 0 WHERE id = '" . $id . "'");
    $this->db->query("UPDATE confy_" . $this->url . "_regform SET id = '" . $id . "' WHERE id = '" . $id . "'-1");
    $this->db->query("UPDATE confy_" . $this->url . "_regform SET id = '" . $id . "'-1 WHERE id = 0");
  
  }
  
  
  /* Updates registration form notes */
  public function editNotes($notes) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_configuration SET value = '" . $notes . "' WHERE setting = 'regform_notes'");
  
  }
  
  
  /* Returns caption of given db_column */
  public function getCaption($db_column) {
                      
    $query = $this->db->query("SELECT caption FROM confy_" . $this->url . "_regform 
                               WHERE db_column = '" . $db_column . "'");
  
    $data = mysqli_fetch_array($query);
    return $data['caption'];
    
  }
  
  
  /* Checks whether given email is already registered. Second argument is used when we want to exclude ID of specific participant from the search */
  public function checkEmailAvailable($email, $id = false) {
    
    /* Search for the same URL in existing pages */
    if ($id == false) {
    
      $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_participants 
                                 WHERE email = '" . $email . "'");
    } else {
    
      $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_participants 
                               WHERE email = '" . $email . "' AND id != '" . $id . "'");
    
    }
    
    /* If there is 0 matches, e-mail is available */                 
    if (mysqli_num_rows($query) == 0) {
      return true;
    } else {
      return false;
    }         
                       
  }


}

?>