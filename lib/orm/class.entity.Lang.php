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
		
		$this->add(new OrmField('isdefault'		
			, OrmCAST::$INTEGER
			, 1	
		));

		$this->garnishAutoincrement();	

		$this->addIndexes(array('code'), true);
		$this->addIndexes(array('isdefault'));

		$this->garnishDefaultValue('isdefault',0);
		
		$this->garnishDefaultOrderBy(new OrmOrderBy(array('isdefault'=>OrmOrderBy::$DESC, 'code'=>OrmOrderBy::$ASC)));
	}	
}
?>