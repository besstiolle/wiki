<?php


class Authentification{

	private static $is_readable = false;

	private static $is_writable = false;

	private static $is_deletable = false;

	private static $author_name = null;

	private static $author_id = null;

	private function __construct(){}

	public static function setStatus($is_readable = false, $is_writable = false, $is_deletable = false, $author_name = null, $author_id = null){
		self::$is_readable = $is_readable;
		self::$is_writable = $is_writable;
		self::$is_deletable = $is_deletable;
		self::$author_name = $author_name;
		self::$author_id = $author_id;

		/*if($is_readable){
			echo "1true";
		}else {
			echo "1false : ".$is_readable;
		}
		if(self::$is_readable){
			echo "2true";
		}else {
			echo "2false : ".self::$is_readable;
		}*/

	}

	public static function is_readable(){
		/*if(self::$is_readable){
			echo "3true";
		}else {
			echo "3false : ".self::$is_readable;
		}*/


		return self::$is_readable;
	}

	public static function is_writable(){
		return self::$is_writable;
	}

	public static function is_deletable(){
		return self::$is_deletable;
	}

	public static function get_author_name (){
		return self::$author_name;
	}

	public static function get_author_id(){
		return self::$author_id;
	}
}

?>