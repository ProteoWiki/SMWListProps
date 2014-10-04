<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo 'Not a valid entry point';
	exit( 1 );
}

if ( !defined( 'SMW_VERSION' ) ) {
	echo 'This extension requires Semantic MediaWiki to be installed.';
	exit( 1 );
}

# Extension credits
$GLOBALS['wgExtensionCredits']['semantic'][] = array(
	'path' => __FILE__,
	'name' => 'SMWListProps',
	'author' => array(
		'[https://www.mediawiki.org/wiki/User:Toniher Toni Hermoso]'
	),
	'version' => '0.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SMWListProps',
	'descriptionmsg' => 'smwlistprops-desc',
);


// i18n
$GLOBALS['wgMessagesDirs']['SMWListProps'] = dirname( __FILE__ ) . 'i18n';
$GLOBALS['wgExtensionMessagesFiles']['SMWListProps'] = dirname( __FILE__ ) . '/SMWListProps.i18n.php';
$GLOBALS['wgExtensionMessagesFiles']['SMWListPropsMagic'] = dirname( __FILE__ ) . '/SMWListProps.i18n.magic.php';

// Autoloading
$GLOBALS['wgAutoloadClasses']['SMWListProps'] = dirname( __FILE__ ) . '/SMWListProps.classes.php';

$wgHooks['ParserFirstCallInit'][] = 'wfRegisterSMWListProps';


// Hooks
function wfRegisterSMWListProps( $parser ) {

	$parser->setFunctionHook( 'SMWListProps', 'SMWListProps::executeGetListProps', SFH_OBJECT_ARGS );
	return true;

}

