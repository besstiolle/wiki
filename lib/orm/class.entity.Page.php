<?php
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
			, 50
			, TRUE	
		));
		
		$this->add(new OrmField('alias'		
			, OrmCAST::$STRING
			, 100
		));

		$this->add(new OrmField('lvl'
			, OrmCAST::$INTEGER 
			, 3
		));
			
		$this->garnishAutoincrement();

		$this->addIndexes(array('lvl'));
		$this->addIndexes(array('prefix', 'alias'), true);
		
		
		$this->garnishDefaultOrderBy(new OrmOrderBy(array(
				'lvl'=>OrmOrderBy::$ASC,
				'alias'=>OrmOrderBy::$ASC
				)));
	}	
}
?>