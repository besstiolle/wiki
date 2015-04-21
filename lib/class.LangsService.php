<?php

class LangsService{

	public static function getOne($code){
		$example = new OrmExample();
		$example->addCriteria('code', OrmTypeCriteria::$EQ, array($code));
		$langs = OrmCore::findByExample(new Lang(),$example);
		if(!empty($langs)){
			return $langs[0];
		}
		return null;
	}

	public static function getOneById($id){
		$example = new OrmExample();
		$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($id));
		$langs = OrmCore::findByExample(new Lang(),$example);
		if(!empty($langs)){
			return $langs[0];
		}
		return null;
	}
}