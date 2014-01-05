<?php


class Motors{

	public static $MARKDOWN = 1;

	public static function process($text, $prefix, $prefix_lang, $motor = 1){
		//Prepare configuration
		$config = cmsms()->GetConfig();
		include_once($config['root_path'].'/modules/Wiki/lib/Michelf/MarkdownExtra.inc.php');
		
		//die($text);
		
		//Transform {root_url}, "!" symbol
		$search = array('{root_url}', '&#33;');
		$replace = array($config['root_url'], '!');
		$text = str_replace($search, $replace, $text);
		
		//Transform blockquote
		$search = array('`\n ?&gt; &gt; &gt; &gt; &gt; &gt; `','`\n ?&gt; &gt; &gt; &gt; &gt; `','`\n ?&gt; &gt; &gt; &gt; `','`\n ?&gt; &gt; &gt; `','`\n ?&gt; &gt; `','`\n ?&gt; `');
		$replace = array('> > > > > >', '> > > > > ','> > > > ','> > > ','> > ','> ');
		$text = preg_replace($search, $replace, $text);
		$search = array('`^ ?&gt; &gt; &gt; &gt; &gt; &gt; `','`\n ?&gt; &gt; &gt; &gt; &gt; `','`^ ?&gt; &gt; &gt; &gt; `','`^ ?&gt; &gt; &gt; `','`^ ?&gt; &gt; `','`^ ?&gt; `');
		$text = preg_replace($search, $replace, $text);
		
		// Process the text : 
		$text = Michelf\Markdown::defaultTransform($text);

		$patternS = '`<a ([^<]*)href=[\'\"]([^<]*)[\'\"]>([^<]*)</a>`si';
		preg_match_all( $patternS, $text, $matches, PREG_SET_ORDER);
		$search = array();
		$replace = array();
		//print_r($matches);
		foreach($matches as $match) {
			// External link
			if(substr($match[2], 0, 7)== 'http://' 
				|| substr($match[2], 0, 8)== 'https://'){
				$cssClass = 'external';
				$title = "";
				$url = $match[2];
			}else {
				//Internal link
				$example = new OrmExample();
				$example->addCriteria('title', OrmTypeCriteria::$EQ, array($match[2]));
				$versions = OrmCore::findByExample(new Version(),$example);
				if(count($versions) == 0){
					$cssClass = 'new';
					$title = "Clic to create the page {$match[2]}";
				} else {
					$cssClass = 'follow';
					$title = "";
				}
				$url = "{$config['root_url']}/{$prefix}{$prefix_lang}/{$match[2]}";
			}
			//Replace plain text without regex anymore
			$search[] = $match[0];
			$replace[] = "<a class='wikilinks {$cssClass}' title='{$title}' href='{$url}'>{$match[3]}</a>";
		}

		$text = str_replace($search,$replace,$text);
		
		return $text;
	}
}
?>
