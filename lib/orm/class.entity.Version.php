<?php
/**
 * A very simple example of how you can define a "User" without any relation to another Object.
 */ 
class Page extends OrmEntity
{
	public function __construct()
	{
		parent::__construct('Wiki','Page');
		
		$this->add(new OrmField('version_id'	
			, OrmCAST::$INTEGER 
			, null	
			, null
			, OrmKEY::$PK	
		));
		
		// the title = the url
		$this->add(new OrmField('title'
			, OrmCAST::$STRING
			, 255	
		));
		
		// the content
		$this->add(new OrmField('description'		
			, OrmCAST::$BUFFER 
		));
		
		// the inner motor
		$this->add(new OrmField('motor'
			, OrmCAST::$INTEGER	
		));
		
		// DateTime of Creation (a modification = a new creation)
		$this->add(new OrmField('dt_creation'
			, OrmCAST::$DATETIME
		));
		
		// Link to the original page to preserve the history
		$this->add(new OrmField('page_id'		
			, OrmCAST::$INTEGER
			, null	
			, null
			, OrmKEY::$FK
			, "Page.page_id"
		));
		
		// Link to the lang category to offer Multi-Lang edition
		$this->add(new OrmField('lang_id'		
			, OrmCAST::$INTEGER
			, null	
			, null
			, OrmKEY::$FK
			, "Lang.lang_id"
		));
		
		// Not required link to the author (integer or string or both)
		$this->add(new OrmField('author_string'
			, OrmCAST::$STRING
			, 255	
			, TRUE
		));
		$this->add(new OrmField('author_id'
			, OrmCAST::$INTEGER
			, null
			, TRUE
		));
		
	}	
}
?>