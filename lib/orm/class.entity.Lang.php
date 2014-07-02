<?php
class Lang extends OrmEntity {

	public function __construct() {
		parent::__construct('Wiki','Lang');
		
		$this->add(new OrmField('lang_id'	
			, OrmCAST::$INTEGER 
			, null	
			, null
			, OrmKEY::$PK	
		));
		
		$this->add(new OrmField('code'		
			, OrmCAST::$STRING
			, 50
			, TRUE	
		));
		
		$this->add(new OrmField('label'		
			, OrmCAST::$STRING
			, 255	
		));
	/*	
		$this->add(new OrmField('page_id'		
			, OrmCAST::$INTEGER
			, 50	
			, null
			, OrmKEY::$FK
			, "Page.page_id"
		));
	*/	
		$this->garnishAutoincrement();	
		
		$this->garnishDefaultOrderBy(new OrmOrderBy(array('lang_id'=>OrmOrderBy::$ASC)));
	}	
}
?>