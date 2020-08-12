<?php 
namespace src\Core;
class DB
{
	static $db;
	static function getDB(){ // getDB
		if( is_null(self::$db) ){
			$options = [\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ];
			self::$db = new \PDO("mysql:host=localhost;charset=utf8mb4;dbname=200811","root","",$options);
		}
		return self::$db;
	}
	static function exec($sql,$d){ // exec
		$row = self::getDB()->prepare($sql);
		try{
			$row->execute($d);
			return true;
		}catch(\Exception $e){
			return false;
		}
	}
	static function fetch($sql,$d){ // fetch
		$row = self::getDB()->prepare($sql);
		$row->execute($d);
		return $row->fetch();
	}
	static function fetchAll($sql,$d){ // fetchAll
		$row = self::getDB()->prepare($sql);
		$row->execute($d);
		return $row->fetchAll();
	}
	static function last(){ // lastInsertId
		return self::getDB()->lastInsertId();
	}
}