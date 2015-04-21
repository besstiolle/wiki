<?php

if (!function_exists("cmsms")) exit;

class PagesService{


	public static function getOneByAlias($prefix, $alias){
		$example = new OrmExample();
		$example->addCriteria('prefix', OrmTypeCriteria::$EQ, array($prefix));
		$example->addCriteria('alias', OrmTypeCriteria::$EQ, array($alias));
		$pages = OrmCore::findByExample(new Page(),$example);
		if(!empty($pages)){
			return $pages[0];
		}
		return null;
	}

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
		$pages = OrmCore::findByExample(new Page(),$example);
		return $pages;
	}
}