<?php

require_once './src/tutorial/autoload.php';

// Load My Link Provider
require dirname(__FILE__).'/MyLinkProvider.php';

// The document is actually loaded and parsed into an internal abstract syntax tree
$document = new ezcDocumentEzXml();
$document->loadFile( dirname(__FILE__).'/myEZXMLFile.xml' );

// Set link provider
$converter = new ezcDocumentEzXmlToDocbookConverter();
$converter->options->linkProvider = new myLinkProvider();

// The document is converted
$docbook = $converter->convert( $document );

// We store it in a new file
$myDocbookResult = fopen(dirname(__FILE__).'/02_eZXML_link_handling_result.xml', 'a+');
fputs($myDocbookResult, $docbook->save() );
fclose($myDocbookResult);
