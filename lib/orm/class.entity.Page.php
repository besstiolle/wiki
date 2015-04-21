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
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
=======
		));

		$this->add(new OrmField('lvl'
			, OrmCAST::$INTEGER 
			, 3
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		));
			
		$this->garnishAutoincrement();

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		$this->addIndexes(array('prefix', 'alias'));
		
		
		$this->garnishDefaultOrderBy(new OrmOrderBy(array('alias'=>OrmOrderBy::$ASC)));
=======
		$this->addIndexes(array('lvl'));
		$this->addIndexes(array('prefix', 'alias'), true);
		
		
		$this->garnishDefaultOrderBy(new OrmOrderBy(array(
				'lvl'=>OrmOrderBy::$ASC,
				'alias'=>OrmOrderBy::$ASC
				)));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
	}	
}
?>