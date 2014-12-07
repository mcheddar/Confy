<?php
/*****************************************************/
/* The class handles operations with user's account  */
/*****************************************************/ 

require_once('db.class.php');
require_once('messages.class.php');


class UserAccount {

  public $db;
  public $messages;
  public $url;
  public $user_id;
  
  
  /* Connects to the database and assigns URL of current conference page */
  public function UserAccount($url) {
  
    $this->db = Db::getInstance();
    $this->url = $url;
    $this->messages = new Messages($url);
    
    session_start();
    $this->user_id = $_SESSION[$this->url . '_user_logged'];
  
  }
  
  
  /* Creates an user account session after successful login */
  private function createSession($id) {
  
    /* First, we need to get some info */
    $ip = $_SERVER["REMOTE_ADDR"];
    $time = time();
    $random_num = mt_rand();
    
    /* Insert the data about this session into the database */
    $this->db->query("INSERT INTO confy_" . $this->url . "_sessions (id, user_id, ip, time, random_num) 
                      VALUES ('', '" . $id . "', '" . $ip . "', '" . $time . "', '" . $random_num . "')");
    
    session_start();

    /* Save the exact same data to the SESSION variable */               
    $_SESSION[$this->url . '_user_logged'] = $id;
    $_SESSION[$this->url . '_user_ip'] = $ip;
    $_SESSION[$this->url . '_user_time'] = $time;
    $_SESSION[$this->url . '_user_random_num'] = $random_num;   
    
    /* Set the user_id private variable */
    $this->user_id = $id;       
                       
  }
  
  /* Destroys the actual session */
  private function destroySession() {
  
    session_start();
  
    unset($_SESSION[$this->url . '_user_logged']);
    unset($_SESSION[$this->url . '_user_ip']);
    unset($_SESSION[$this->url . '_user_time']);
    unset($_SESSION[$this->url . '_user_random_num']);  
  
  }
  
  
  /* Authenticates the actual session by comparing the data in the SESSION variable with the data in the database. 
     If any of the info is missing or has been changed, we're propably dealing with an unauthorized access. */
  private function authSession() {
  
    session_start();
  
    /* Try to get the exact same data from the sessions log in the database */
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_sessions 
                               WHERE user_id = '" . $_SESSION[$this->url . '_user_logged'] . "' AND
                                     ip = '" . $_SESSION[$this->url . '_user_ip'] . "' AND
                                     time = '" . $_SESSION[$this->url . '_user_time'] . "' AND
                                     random_num = '" . $_SESSION[$this->url . '_user_random_num'] . "'");
    
    /* If we got exactly one result, access is authorized */                 
    if (mysqli_num_rows($query) == 1) {
      return true;
    } else {
      return false;
    }

  }
  
  
  /* Tries to log in the participant */
  public function logIn($email, $password) {
  
    /* Lets verify the password */
    $query = $this->db->query("SELECT id, password FROM confy_" . $this->url . "_participants WHERE email='" . $email . "'");
    $login_data = mysqli_fetch_array($query);
    
    
    /* If the password is correct, log in the user by creating new session */
    if ($login_data["password"] == MD5($password)) {
      $this->createSession($login_data["id"]);
      return true;
    } else {
      return false;
    } 
  
  }
  
  
  /* Logs out the user */
  public function logOut() {
  
    $this->destroySession();
    $this->user_id = false;
  
  }
  
  
  /* Checks if the user is correctly logged in */
  public function isLogged() {
  
    return $this->authSession();
  
  }
  
  
  /* Changes participant's registration data */
  public function editUser($data, $id = false) {
  
    /* If ID argument is not given, change data of the currently logged in user */
    if (!$id) {
      $id = $this->user_id;
      $send_email = true;
    }

    /* Insert each value, one by one */                   
    foreach ($data as $db_column => $value) {

      $this->db->query("UPDATE confy_" . $this->url . "_participants
                        SET " . $db_column . " = '" . $value . "'
                        WHERE id = '" . $id . "'");
                        
    }
    
 
    /* If this is not a new registration, send confirmation email with reviewed information */
    if ($send_email) {
    
      $this->messages->changeRegistration($id);
      
    }   

  }
  
  
  /* Registers a new participant and returns his ID */
  public function register($data) {
  
    /* Insert blank row into the Participants table */
    $this->db->query("INSERT INTO confy_" . $this->url . "_participants (id)
                      VALUES ('')");
    
    /* Determine the ID of that blank row */                  
    $result = $this->db->query("SELECT id FROM confy_" . $this->url . "_participants ORDER BY id DESC");
    $data_id = mysqli_fetch_array($result);
    
    /* Insert data of this Participant to the database */
    $this->editUser($data, $data_id['id']);
    
    /* Generate a random password for user */
    $password = randomPassword();
    
    /* Save the password */
    $this->changePassword($password, $data_id['id']);
    
    /* Send an confirmation e-mail with the password */
    $this->messages->newRegistration($data_id['id'], $password);
    
    /* Return user's ID */
    return $data_id['id'];
  }
  
  
  /* Verifies validity of user's password */
  public function verifyPassword($password) {
  
    /* Lets verify the password */
    $query = $this->db->query("SELECT password FROM confy_" . $this->url . "_participants WHERE id='" . $this->user_id . "'");
    $login_data = mysqli_fetch_array($query);
    
    
    /* Check if the password is correct */
    if ($login_data["password"] == MD5($password)) {
      return true;
    } else {
      return false;
    } 
  
  }
  
  
  /* Sets a new password. If no ID is given, function sets password for the currently logged in user */
  public function changePassword($password, $id = false) {
  
    if (!$id) {
      $id = $this->user_id;
    }

    /* Save the password to the database, MD5 encoded */
    $this->db->query("UPDATE confy_" . $this->url . "_participants
                      SET password = '" . md5($password) . "'
                      WHERE id = '" . $id . "'");

  }
  
  
  /* Resets a password associated to the given e-mail address */
  public function resetPassword($email) {
  
    /* Is there a user with provided e-mail address? */
    $query = $this->db->query("SELECT id FROM confy_" . $this->url . "_participants WHERE email='" . $email . "'");
    $count = mysqli_num_rows($query);
    
    if ($count == 0) {
    
      return false;
    
    } else {
    
      /* Generate a random password for user */
      $password = randomPassword();
    
      /* Get user's ID */
      $data = mysqli_fetch_array($query);
      
      /* Change user's password */
      $this->changePassword($password, $data['id']);
      
      /* Send an email with the new password */
      $this->messages->resetPassword($data['id'], $password);
      
      return true;
    }
  
  }
  
  
  /* Returns an participant's registration data. If no argument is given, returns the data of currently logged in user */
  public function getUserData($id = false) {
  
    if (!$id) {
      $id = $this->user_id;
    }
  
    $result = $this->db->query("SELECT * FROM confy_" . $this->url . "_participants WHERE id = '" . $id . "'");
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
  
  }
  
  
  /* Returns all registered participants */
  public function getAllUsers() {
  
    return $this->db->query("SELECT * FROM confy_" . $this->url . "_participants ORDER BY last_name ASC");
  
  }
  

  
}

?>