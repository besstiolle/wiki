<?php

if (!function_exists("cmsms")) exit;

class PagesService{

	public static function getOneById($id){
		$example = new OrmExample();
		$example->addCriteria('page_id', OrmTypeCriteria::$EQ, array($id));
		$pages = OrmCore::findByExample(new Page(),$example);
		if(!empty($pages)){
			return $pages[0];
		}
		return null;
	}

	public static function getOneByTitle($title){
		$example = new OrmExample();
		$example->addCriteria('title', OrmTypeCriteria::$EQ, array($title));
		$pages = OrmCore::findByExample(new Page(),$example);
		if(!empty($pages)){
			return $pages[0];
		}
		return null;
	}

	public static function getByTitleLike($title){
		$example = new OrmExample();
		$example->addCriteria('title', OrmTypeCriteria::$LIKE, array($title));
		$pages = OrmCore::findByExample(new Page(),$example);
		return $pages;
	}
}