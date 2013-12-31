<?php
/**
 * A very simple example of how you can define a "User" without any relation to another Object.
 */ 
class Page extends OrmEntity {

	public function __construct() {
		parent::__construct('Wiki','Page');
		
		$this->add(new OrmField('page_id'	
			, OrmCAST::$INTEGER 
			, null	
			, null
			, OrmKEY::$PK	
		));
		
		$this->add(new OrmField('prefix'		
			, OrmCAST::$STRING
			, 255
			, TRUE	
		));
		
		$this->add(new OrmField('title'		
			, OrmCAST::$STRING
			, 255	
		));
			
		$this->garnishAutoincrement();
		
		$this->garnishDefaultOrderBy(new OrmOrderBy(array('title'=>OrmOrderBy::$ASC)));
	}	
}
?>