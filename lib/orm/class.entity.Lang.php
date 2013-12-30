<?php
/**
 * A very simple example of how you can define a "User" without any relation to another Object.
 */ 
class Page extends OrmEntity
{
	public function __construct()
	{
		parent::__construct('Wiki','Page');
		
		$this->add(new OrmField('lang_id'	
			, OrmCAST::$INTEGER 
			, null	
			, null
			, OrmKEY::$PK	
		));
		
		$this->add(new OrmField('label'		
			, OrmCAST::$STRING
			, 255	
		));
		
		$this->add(new OrmField('page_id'		
			, OrmCAST::$INTEGER
			, 50	
			, null
			, OrmKEY::$FK
			, "Page.page_id"
		));
				

	}	
}
?>