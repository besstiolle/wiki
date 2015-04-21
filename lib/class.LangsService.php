<?php

class LangsService{

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
	public static function findOne($code){
=======
	public static function getOne($code){
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		$example = new OrmExample();
		$example->addCriteria('code', OrmTypeCriteria::$EQ, array($code));
		$langs = OrmCore::findByExample(new Lang(),$example);
		if(!empty($langs)){
			return $langs[0];
		}
		return null;
	}
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
=======

	public static function getOneById($id){
		$example = new OrmExample();
		$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($id));
		$langs = OrmCore::findByExample(new Lang(),$example);
		if(!empty($langs)){
			return $langs[0];
		}
		return null;
	}
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
}