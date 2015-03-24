<?php

class VersionsService{

	public static function getOne($page_id = null, $lang_id = null, 
							$version_id = null, $status = null){

		$versions = VersionsService::getAll($page_id, $lang_id, 
							$version_id, $status);

		if(!empty($versions)){
			return $versions[0];
		}
		return null;
	}
	public static function getAll($page_id = null, $lang_id = null, 
							$version_id = null, $status = null, $ormLimit = null){

		$example = new OrmExample();

		if($page_id != null){
			$example->addCriteria('page', OrmTypeCriteria::$EQ, array($page_id));
		}

		if($lang_id != null){
			$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($lang_id));
		}

		if($version_id != null){ 
			$example->addCriteria('version_id', OrmTypeCriteria::$EQ, array($version_id));
		} 

		if($status != null){
			$example->addCriteria('status', OrmTypeCriteria::$EQ, array($status));
		}

		return OrmCore::findByExample(new Version(),$example, null, $ormLimit);
	}
}