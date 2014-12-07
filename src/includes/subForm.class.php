<?php
/*********************************************************/
/* The class handles operations with an submission form  */
/*********************************************************/ 

require_once('db.class.php');
require_once('messages.class.php');

class SubForm {

  public $db;
  public $url;
  public $messages;
  
  
  /* Connects to the database and assigns URL of current conference page */
  public function SubForm($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
    $this->messages = new Messages($url);
  
  }
  
  
  /* Adds a new submission topic */
  public function addTopic($topic) {

    /* Put the new topic to the database */                           
    $this->db->query("INSERT INTO confy_" . $this->url . "_topics (id, topic)
                      VALUES ('', '" . $topic . "')"); 

  }
  
  
  /* Updates topic's title */
  public function editTopic($id, $topic) {

    /* Update the Topics table */
    $this->db->query("UPDATE confy_" . $this->url . "_topics
                      SET topic = '" . $topic . "'
                      WHERE id = '" . $id . "'");
  
  }
  
  
  /* Returns all topics */
  public function getAllTopics() {
  
    /* Get topics' data */
    return $this->db->query("SELECT * FROM confy_" . $this->url . "_topics ORDER BY id ASC");
  
  }
  
  
  /* Returns one topic */
  public function getTopic($id) {
  
    /* Get field's data */
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_topics WHERE id = '" . $id . "'");
    return mysqli_fetch_array($result);
  
  }
  
  
  /* Deletes a topic from the database */
  public function deleteTopic($id) {

    /* Delete topic the Topics table */
    $this->db->query("DELETE FROM confy_" . $this->url . "_topics 
                      WHERE id = '" . $id . "'");
                 
  }
  
  
  /* Updates submission form notes */
  public function editNotes($notes) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_configuration SET value = '" . $notes . "' WHERE setting = 'subform_notes'");
  
  }
  
  
  /* Updates allowed file types */
  public function editFileTypes($file_types) {
                      
    $this->db->query("UPDATE confy_" . $this->url . "_configuration SET value = '" . $file_types . "' WHERE setting = 'subform_file_types'");
  
  }
  
  
  /* Checks if the uploaded file has allowed file extension */
  public function checkFile($filename) {
  
    /* Get allowed file types */
    $result = $this->db->query("SELECT value FROM confy_" . $this->url . "_configuration WHERE setting = 'subform_file_types'");
    $data = mysqli_fetch_array($result);
    
    /* Explode the allowed file types and get rid of the space characters, if there are any */
    $delimiter = ',';
    $file_types = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $data['value'])); 
    $file_types_arr = explode($delimiter, $file_types);
    
    /* Get file's extension */
    $extension = getExtension($filename);
    
    /* Is the file extension in allowed file types? */
    if (in_array($extension, $file_types_arr)) {
      return true;
    } else {
      return false;
    }
    
  }
  
  
  public function addPaper($type, $topic, $title, $file, $user_data) {
  
    /* Insert paper info to the database */                           
    $this->db->query("INSERT INTO confy_" . $this->url . "_papers (id, author, time, file, type, topic, title)
                      VALUES ('', '" . $user_data['id'] . "', '" . time() . "', '', '" . $type . "', '" . $topic . "', '" . $title . "')");
                      
    /* Determine the ID of recently inserted paper */                  
    $result = $this->db->query("SELECT id FROM confy_" . $this->url . "_papers ORDER BY id DESC");
    $data_id = mysqli_fetch_array($result);                   
  
    /* Set correct file name and path to upload */
    $filename = removeDiacritics($user_data['last_name']) . '-' . $data_id['id'] . '.' . getExtension($file['name']);
    $path = 'conferences/' . $this->url . '/';
    
    /* Upload the file to the selected directory */
    uploadFile($file, $filename, $path);

    /* Insert also file name to the database */
    $this->db->query("UPDATE confy_" . $this->url . "_papers SET file = '" . $filename . "' WHERE id = '" . $data_id['id'] . "'");
    
    /* Get topic name */
    $data_topic = $this->getTopic($topic);
    
    $this->messages->newPaper($user_data['id'], $type, $data_topic['topic'], $title);
  
  }
  
  
  /* Returns user's papers. If no id is provided, returns all contributed papers */
  public function getPapers($id = false) {
  
    if ($id) {
      return $this->db->query("SELECT * FROM confy_" . $this->url . "_papers WHERE author = '" . $id . "' ORDER BY time DESC");   
    } else {
      return $this->db->query("SELECT * FROM confy_" . $this->url . "_papers ORDER BY time DESC");   
    }
  
  
  }
  
  
  /* Deletes a paper */
  public function deletePaper($id) {

    /* Get paper's data */
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_papers WHERE id = '" . $id . "'");
    $data = mysqli_fetch_array($result);
    
    /* Delete paper from the server */
    unlink('conferences/' . $this->url . '/' . $data['file']);  
   
    /* Delete paper from the database */
    $this->db->query("DELETE FROM confy_" . $this->url . "_papers
                      WHERE id = '" . $id . "'");
                      
    /* Get topic name */
    $data_topic = $this->getTopic($data['topic']);                  
                      
    $this->messages->deletePaper($data['author'], $data['type'], $data_topic['topic'], $data['title']);
                 
  }


}

?>