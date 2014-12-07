<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo 'Not a valid entry point';
	exit( 1 );
}

if ( !defined( 'SMW_VERSION' ) ) {
	echo 'This extension requires Semantic MediaWiki to be installed.';
	exit( 1 );
}


/**
 * This class handles the search for Props.
 */
class SMWListProps {
	
	public static function executeGetListProps( $parser, $frame, $args ) {
	
		//Default current page
		$pagetitle = $parser->getTitle();

		// Let's get page
		if ( isset( $args[0] ) && $args[0]!='' ) {
			$title = trim( $frame->expand( $args[0] ) );
			$pagetitle = Title::newFromText( $title );
		}
		
		if ( ! $pagetitle ) {
			return '';
		}

		$smwpagetitle = SMWDIWikiPage::newFromTitle( $pagetitle );
	
		$data = smwfGetStore()->getSemanticData( $smwpagetitle );
		$diProperties = $data->getProperties();
	
		$listprops = array();
	
		// We remove param 0
		array_shift($args);
	
		$params = array();
	
		// We parametrize
		foreach ( $args as $arg ) {
			array_push( $params, trim( $frame->expand( $arg ) ) );
		}
	
		// Options 
		$wikionly = false;
		$values = false;
		$sep = ",";
		$sepvalues = "-";
		$eqvalues = ":";
	
	
		// If value in array
		if ( in_array ( 'wikionly' , $params ) ) {
			$wikionly = true;
		}
		// If value in array
		if ( in_array ( 'values' , $params ) ) {
			$values = true;
		}

		// Detect array
		$separr = preg_grep( "/^sep\=/", $params );
		$sepvaluesarr = preg_grep( "/^sepvalues\=/", $params );
		$eqvaluesarr = preg_grep( "/^eqvalues\=/", $params );

		// We assume first match
		if ( count( $separr ) > 0 ) {
			$seppr = $separr[0];
			$vals = explode( "=", $seppr, 2 );
			if ( ! empty( $vals[1] ) ) {
				$sep =  $vals[1];
			}
		}
		if ( count( $sepvaluesarr ) > 0 ) {
			$sepvaluespr = $sepvaluesarr[0];
			$vals = explode( "=", $sepvaluespr, 2 );
			if ( ! empty( $vals[1] ) ) {
				$sepvalues =  $vals[1];
			}
		}
		if ( count( $eqvaluesarr ) > 0 ) {
			$eqvaluespr = $eqvaluesarr[0];
			$vals = explode( "=", $eqvaluespr, 2 );
			if ( ! empty( $vals[1] ) ) {
				$eqvalues =  $vals[1];
			}
		}
		
		foreach ( $diProperties as $diProperty ) {
	
			// Check if user defined
			if ( $wikionly == true && !$diProperty->isUserDefined() ) {
				continue;
			}
	
			$label = $diProperty->getLabel();
			if ( !empty($label)  ) {
	
				if ( $values == true ) {
					$result = self::getPropValue( $pagetitle->getFullText(), $label );
					
					if ( is_array( $result ) ) {
						$strarray = implode( $sepvalues, $result );
					} else {
						$strarray = $result;
					}
					
					
					$label = $label.$eqvalues.$strarray;
				}
			
				array_push( $listprops, $label );
			}
		}

	
		return( implode( $sep, $listprops ) );
	
	}

	/** Convenient for getting value **/
	
	static function getPropValue ( $title_text, $query_word ) {
		
		// Ensure proper query
		$query_word = str_replace(" ", "_", $query_word);
		
		// https://semantic-mediawiki.org/wiki/User:Yury_Katkov/programming_examples
		$params = array ("[[$title_text]]", "?$query_word", "mainlabel=-", "headers=hide" );
		$result = SMWQueryProcessor::getResultFromFunctionParams( $params, SMW_OUTPUT_WIKI );

		return $result;
	}


}
