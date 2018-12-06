<?php
//require "Database.php";
class Member {
//	private $firstname;
//	private $lastname;
//	private $id;
//	private $email;
//	private $gender;
//	private $joined_date;

	public  function getMembers($limit = NULL , $startFrom = NULL) {
		$db = new Database();
		$sql = 'SELECT * FROM `members` ';
		if($limit != NULL &&  $startFrom != NULL) {
			$sql = $sql. ' LIMIT '. $startFrom . ' , '. $limit;
		} elseif($limit != NULL) {
			$sql = $sql. ' LIMIT '. $limit;
		}
		$members = $db->fetch_array($sql);
		return $members;
	}

	public function getMember($filter) {
		$sql = 'SELECT * FROM `members` WHERE';
		if ( is_array($filter) ){
            if( ! empty($filter) ){
                foreach($filter as $key=>$val){
                    if($val!='' && $val!= NULL)  $sql.= "`$key`='".$val."' AND ";
                }
			}
		}
		$sql = rtrim($sql, "AND ");
		$db = DataBase::getDbInstance();
		$members = $db->fetch_array($sql);

		return $members;

	}

	public function getMembersSingupByYear() {
		$db = DataBase::getDbInstance();
		$sql = "SELECT COUNT(*) as y, YEAR(joined_date) as label FROM `members` GROUP BY YEAR(joined_date)";
		$membersSignupbyYear = [];
		foreach($db->fetch_array($sql) as $perYear){
			foreach($perYear as $key=>$val){
				if($key == 'y') {
					$perYear[$key] = intval($val);
				}
			}
            $membersSignupbyYear[] = $perYear;
        }
		return $membersSignupbyYear;
	}

	public function getNumberOfMember() {
		$db = DataBase::getDbInstance();
		$sql = "SELECT COUNT(*) as totalMembers FROM `members` ";
		$totalMember =  $db->query_first($sql);
		foreach ($totalMember as $key => $value) {
			return $value;
		}
	}

}





?>