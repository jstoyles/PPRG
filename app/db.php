<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/vendor/php/htmlpurifier/library/HTMLPurifier.auto.php';
class DB{
    private static $dbconnect;
	private $dbtype, $dbhost, $dbname, $dbuser, $dbpassword;
    public $error = NULL;

	public function __construct($dbtype=DB_TYPE, $dbhost=DB_HOST, $dbname=DB_DB, $dbuser=DB_USER, $dbpassword=DB_PASSWORD)
	{
		$this->dbtype = $dbtype;
		$this->dbhost = $dbhost;
		$this->dbname = $dbname;
		$this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
        
        $this->purifierConfig = HTMLPurifier_Config::createDefault();
        $this->purifier = new HTMLPurifier($purifierConfig);
	}
    private function __clone(){} // Make private to block from cloning

	public function dbConnect() {
		if (!self::$dbconnect){
			try {
				switch(strtolower($this->dbtype)){
					case'sqlite':
						self::$dbconnect = new PDO('sqlite:'.CODE_BASE.'/db/db.sqlite'); //For use with sqlite db - make sure folder containing the db file is writable!
						break;
					case'mysql':
						self::$dbconnect = new PDO('mysql:host='.$this->dbhost.';dbname='.$this->dbname, $this->dbuser, $this->dbpassword, array(PDO::ATTR_PERSISTENT=>true)); //For use with mysql
						break;
				}
			}
			catch (PDOException $e) {
				$this->$error = 'Connection failed: '.$e->getMessage();
			}
		}
		return self::$dbconnect;
    }


    //TODO - This could be better and should require parameterized queries at the very least...
    //IMPORTANT: Use with caution as there is no SQL insection protection in place for this yet.
    public function query($sql){
		$c = $this->dbConnect();

		$q = $c->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_OBJ);
		return $q->fetchAll();
    }


    //TODO - This could be better...
    public function select($table, array $fields, array $wherefields=NULL, array $wherevalues=NULL, $orderby=NULL, $orderdir='ASC'){
		$c = $this->dbConnect();

        $sql = ' SELECT ' . implode(',', $fields);
		$sql .= ' FROM ' . $table;
		if(isset($wherefields) && count($wherefields)>0 && count($wherefields)==count($wherevalues)){
            $sql .= ' WHERE ';
            for($x=0; $x<count($wherefields); $x++){
                if($x>0){ $sql .= ' AND '; }
                $sql .= $wherefields[$x] . "='" . trim($this->purifier->purify($wherevalues[$x])) . "'";
            }
        }
        if(isset($orderby)){ $sql .= ' ORDER BY ' . $orderby . ' ' . $orderdir; }

		$q = $c->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_OBJ);
		return $q->fetchAll();
    }

    //TODO - Remove SQL override and force fields
	public function insert($table, array $fields, array $values, $overridesql=NULL){
		$c = $this->dbConnect();
		if(isset($overridesql)){ $sql = $overridesql; }
		else{
			$sql = ' INSERT INTO ' . $table;
			$sql .= ' ( ';
			$cols = '';
			foreach($fields as $field){ $cols .= "".$field.","; }
			$sql .= substr($cols, 0, -1);
			$sql .= ' ) ';
			$sql .= ' VALUES( ';
			$vals = '';
			foreach($values as $value){ $vals .= "'" . trim($this->purifier->purify($value)) . "',"; }
			$sql .= substr($vals, 0, -1);
			$sql .= ' ) ';
		}
		$q = $c->prepare($sql);
		$q->execute();
		return 'Record(s) Inserted';
    }

    //TODO - Remove SQL override and force fields
	public function update($table, $fields, $values, $wherefield, $wherevalue, $overridesql=NULL){
		$c = $this->dbConnect();
		if(isset($overridesql)){ $sql = $overridesql; }
		else{
			$sql = ' UPDATE ' . $table;
			$updateSet = '';
			for($x=0; $x<count($fields); $x++){
				$updateSet .= $fields[$x] . "=" . "'" . trim($this->purifier->purify($values[$x])) . "',";
			}
			$updateSet .= substr($updateSet, 0, -1);
			$sql .= " SET " . $updateSet;
			$sql .= " WHERE " . $wherefield . "=" . "'" . $wherevalue . "'";
		}
		$q = $c->prepare($sql);
		$q->execute();
		return 'Record Updated';
    }

    //TODO - Remove SQL override and force fields
	public function delete($table, $field, $value, $overridesql=NULL){
		$c = $this->dbConnect();
		if(isset($overridesql)){ $sql = $overridesql; }
		else{
			$sql = ' DELETE FROM ' . $table;
			$sql .= " WHERE " . $field . "=" . "'" . trim($this->purifier->purify($value)) . "'";
		}
		$q = $c->prepare($sql);
		$q->execute();
		return 'Record Deleted';
    }

	public function sp($sp, array $params){
		$paramStr = '';
		foreach($params as $param){
            $paramStr .= "'" . trim($this->purifier->purify($param)) . "',";
        }
		$paramStr = substr($paramStr, 0, -1);
		switch(strtolower($this->dbtype)){
			case'mysql':
				$sql = " CALL " . $sp . "(" . $paramStr . ") ";
				break;
			case'mssql':
				$sql = " EXEC " . $sp . " " . $paramStr . " ";
				break;
		}
		$c = $this->dbConnect();
		$q = $c->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_OBJ);
        return $q->fetchAll();
    }

	public function func($fn, array $params){
		$paramStr = '';
		foreach($params as $param){
            $paramStr .= "'" . trim($this->purifier->purify($param)) . "',";
        }
		$paramStr = substr($paramStr, 0, -1);
		$sql = " SELECT " . $fn . "(" . $paramStr . ") ";
		$c = $this->dbConnect();
		$q = $c->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_OBJ);
		return $q->fetchAll();
	}
}

?>