<?php
/********************************************************/
/* The class handles connection with the MySQL database */
/********************************************************/

/* Load the MySQL login data */
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__ . '/config.php'); 


class Db {
	
	private static $singleton = null;
	private $connection = null;
	
	
	/* Connects to the DB server */
	private function __construct() {
		$this->connect();
	}

	
  /* Disconnects from the DB server */
	public function __destruct() {
		$this->disconnect();
	}
	
	
	/* Returns instance of the database class */
	public static function getInstance() {
		if (Db::$singleton == null) {
			Db::$singleton = new Db();
		}
		
		return Db::$singleton;
	}
	
  
	/* Creates connection to the database. If connection already exists, returns the existing connection */
	public function connect() {
  
		if($this->connection == null) {
			$this->connection = mysqli_connect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']) or die("Database error: connection to the database failed." . mysqli_connect_error());
			
		}
		
		return $this->connection == null ? mysqli_error($this->connection) : true;
	}
	
	
	
	/* Closes the connection with the database */
	private function disconnect() {
		if($this->connection != null) {
			mysqli_close($this->connection);
		}
		
		$this->connection = null;
	}
	
	
	/* Performs the SQL query. Returns the result of the query. */
	public function query($query) {

		if($this->connection != null) {
			$result = mysqli_query($this->connection, $query);
			echo mysqli_error($this->connection);
			if(!$result) {
				return false;
			} else {
        return $result;
      }
			
		} else {
			return false;
		}
	}
  
  
  /* Performs the SQL query. Returns the result of the query. */
	public function multi_query($query) {

		if($this->connection != null) {
			mysqli_multi_query($this->connection, $query);

		} else {
			return false;
		}
	}

	
}