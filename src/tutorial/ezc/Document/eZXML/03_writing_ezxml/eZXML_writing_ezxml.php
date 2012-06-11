<?php

require_once './src/tutorial/autoload.php';

// Load My Link Converter
//require dirname(__FILE__).'/MyLinkConverter.php';

// Loading the document in Docbook format
$docbook = new ezcDocumentDocbook();
$docbook->loadFile( dirname(__FILE__).'/myDocbookFile.xml' );

// Preparing eZ XML File
$ezXml = new ezcDocumentEzXml();

// Set link converter
$converter = new ezcDocumentDocbookToEzXmlConverter();
$converter->options->linkConverter = new ezcDocumentEzXmlDummyLinkConverter();

// The Docbook document is converted
$ezXml = $converter->convert( $docbook );

// Transformation in ez xml file
$ezXml->createFromDocbook( $docbook );
$result = $ezXml->save();

// We store it in a new file
$myEZXmlResult = fopen(dirname(__FILE__).'/03_myEZXmlFile.xml', 'a+');
fputs($myEZXmlResult, $result );
fclose($myEZXmlResult);
