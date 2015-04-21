<?php

if (!function_exists("cmsms")) exit;

class PagesService{

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
	public static function getOneById($id){
		$example = new OrmExample();
		$example->addCriteria('page_id', OrmTypeCriteria::$EQ, array($id));
=======

	public static function getOneByAlias($prefix, $alias){
		$example = new OrmExample();
		$example->addCriteria('prefix', OrmTypeCriteria::$EQ, array($prefix));
		$example->addCriteria('alias', OrmTypeCriteria::$EQ, array($alias));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		$pages = OrmCore::findByExample(new Page(),$example);
		if(!empty($pages)){
			return $pages[0];
		}
		return null;
	}

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
	public static function getOneByAlias($alias){
		$example = new OrmExample();
		$example->addCriteria('alias', OrmTypeCriteria::$EQ, array($alias));
		$pages = OrmCore::findByExample(new Page(),$example);
		if(!empty($pages)){
			return $pages[0];
		}
		return null;
	}

	public static function getByAliasLike($alias){
		$example = new OrmExample();
		$example->addCriteria('alias', OrmTypeCriteria::$LIKE, array($alias));
=======
	public static function getByAliasLike($prefix, $alias){
		$example = new OrmExample();
		$example->addCriteria('prefix', OrmTypeCriteria::$EQ, array($prefix));
		$example->addCriteria('alias', OrmTypeCriteria::$LIKE, array($alias));
		$pages = OrmCore::findByExample(new Page(),$example);
		return $pages;
	}

	public static function getSiblings($prefix, $alias){

		$lvl = PagesService::getLvl($alias);

		$pos = strrpos($alias, ':');
		if($pos === false){
			$aliasParent = null;
		} else {
			$aliasParent = substr($alias, 0, $pos);
		}


		$example = new OrmExample();
		if($aliasParent != null){
			$example->addCriteria('alias', OrmTypeCriteria::$LIKE, array($aliasParent.'%'));
		}
		$example->addCriteria('prefix', OrmTypeCriteria::$EQ, array($prefix));
		$example->addCriteria('lvl', OrmTypeCriteria::$EQ, array($lvl));
		$pages = OrmCore::findByExample(new Page(),$example);

		return $pages;

	}

	public static function getLvl($alias){
		return substr_count($alias, ':');
	}

	public static function getByPrefix($prefix){

		$example = new OrmExample();
		$example->addCriteria('prefix', OrmTypeCriteria::$EQ, array($prefix));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		$pages = OrmCore::findByExample(new Page(),$example);
		return $pages;
	}
}