<?php
/*************************************************************************************************/
/* The class handles everything connected with the administrator's account - logging in and out, */
/* creating and destroying sessions, verifying the current session for safety reasons.           */
/*************************************************************************************************/ 

require_once('db.class.php');

class AdminAccount {

  public $db;
  
  
  /* Connects to the database */
  public function AdminAccount() {
  
    $this->db = Db::getInstance();
  
  }

  
  /* Creates an administration account session after successful login */
  private function createSession() {
  
    /* First, we need to get some info */
    $ip = $_SERVER["REMOTE_ADDR"];
    $time = time();
    $random_num = mt_rand();
    
    /* Insert the data about this session into the database */
    $this->db->query("INSERT INTO confy_admin_sessions (id, ip, time, random_num) 
                      VALUES ('', '" . $ip . "', '" . $time . "', '" . $random_num . "')");
    
    session_start();
    
    /* Save the exact same data to the SESSION variable */               
    $_SESSION['admin_logged'] = true;
    $_SESSION['admin_ip'] = $ip;
    $_SESSION['admin_time'] = $time;
    $_SESSION['admin_random_num'] = $random_num;    
    
    /* No conference is selected yet */
    $_SESSION['admin_conference_selected'] = false;    
            
                       
  }
  
  /* Destroys the actual session */
  private function destroySession() {
  
    session_start();
  
    unset($_SESSION['admin_logged']);
    unset($_SESSION['admin_ip']);
    unset($_SESSION['admin_time']);
    unset($_SESSION['admin_random_num']); 
    unset($_SESSION['admin_conference_selected']); 
  
  }
  
  
  /* Authenticates the actual session by comparing the data in the SESSION variable with the data in the database. 
     If any of the info is missing or has been changed, we're propably dealing with an unauthorized access. */
  private function authSession() {
  
    session_start();
  
    /* Try to get the exact same data from the sessions log in the database */
    $query = $this->db->query("SELECT id FROM confy_admin_sessions 
                               WHERE ip = '" . $_SESSION['admin_ip'] . "' AND
                                     time = '" . $_SESSION['admin_time'] . "' AND
                                     random_num = '" . $_SESSION['admin_random_num'] . "'");
    
    /* If we got exactly one result, access is authorized */                 
    if (mysqli_num_rows($query) == 1) {
      return true;
    } else {
      return false;
    }

  }
  
  
  /* Verifies validity of administrator's password */
  public function verifyPassword($password) {
  
    /* Lets verify the password */
    $query = $this->db->query("SELECT value FROM confy_admin_settings WHERE setting='admin_password'");
    $login_data = mysqli_fetch_array($query);
    
    
    /* Check if the password is correct */
    if ($login_data["value"] == MD5($password)) {
      return true;
    } else {
      return false;
    } 
  
  }
  
  
  /* Sets a new administrator's password. */
  public function changePassword($password) {

    /* Save the password to the database, MD5 encoded */
    $this->db->query("UPDATE confy_admin_settings
                      SET value = '" . md5($password) . "'
                      WHERE setting='admin_password'");

  }
  
  
  /* Tries to log in the administrator */
  public function logIn($password) {

    /* If the password is correct, log in the administrator by creating new session */
    if ($this->verifyPassword($password)) {
      $this->createSession();
      return true;
    } else {
      return false;
    } 
  
  }
  
  
  /* Logs out the administrator */
  public function logOut() {
  
    $this->destroySession();
  
  }
  
  
  /* Checks if the administrator is correctly logged in */
  public function isLogged() {
  
    return $this->authSession();
  
  }
  
  
  /* Sets currently selected conference to SESSION variable */
  public function setCurrentConference($url) {
  
    session_start();
    $_SESSION['admin_conference_selected'] = $url;
  
  }
  
  
  /* Returns currently selected conference */
  public function getCurrentConference() {
  
    session_start();
    return $_SESSION['admin_conference_selected']; 
  
  }
  
  
  /* Returns the actual URL address of currenly selected conference */
  public function getConferenceURL() {
  
    $systemURL = substr(currentURL(), 0, strpos(currentURL(), 'admin/'));
    return $systemURL . $this->getCurrentConference();
  
  }

}

?>