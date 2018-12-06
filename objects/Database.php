<?php

class Database {

	private $dbServer;
	private $dbUsername;
	private $dbPassword;
	private $dbName;
    private $conn;
    public static $dbInstance;

	public function __construct($server= DB_SERVER, $username=DB_USER, $password='', $database=DB_DATABASE) {
		$this->dbServer = $server;
		$this->dbUsername = $username;
		$this->dbPassword = $password;
		$this->dbName = $database;
		$this->conn = mysqli_connect($this->dbServer, $this->dbUsername, $this->dbPassword, $this->dbName);
		if(!$this->conn) {
			echo 'Unbale to open the Database ';
		}
    }

    public static function getDbInstance() {
        if(!self::$dbInstance) {
            self::$dbInstance = new DataBase($server= DB_SERVER, $username=DB_USER, $password='', $database=DB_DATABASE);
        }
        return self::$dbInstance;
    }

	public function query($sql){
        $result = $this->conn->query($sql);
        if ($result->num_rows <= 0) {
			return 0;
		} else {
			return $result;
		}
	}

	public function query_first($queryString){
        $result = $this->query($queryString);
        $result = $this->fetch($result);
        return $result;
    }

	public function fetch_array($sql){
        $queryResult = $this->query($sql);
        $result = array();
        while ($row = $queryResult->fetch_assoc()){
            $result[] = $row;
        }
        return $result;
	}

	public function fetch($queryResult){
        // retrieve row
        if (isset($queryResult)){
            $record = $queryResult->fetch_assoc();
        }else{
            echo "Invalid queryId Records could not be fetched.";
            return null;
        }
        return $record;
    }
}


?>