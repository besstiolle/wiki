<?php

class LangsService{

	public static function findOne($code){
		$example = new OrmExample();
		$example->addCriteria('code', OrmTypeCriteria::$EQ, array($code));
		$langs = OrmCore::findByExample(new Lang(),$example);
		if(!empty($langs)){
			return $langs[0];
		}
		return null;
	}
}