<?php

require_once './src/project/autoload.php';

/////////////////////
// RST TO DOCBOOK //
///////////////////

// The RST document is actually loaded and parsed into an internal abstract syntax tree
$rstdoc = new ezcDocumentRst();
//$rstdoc->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;
$rstdoc->loadFile( dirname(__FILE__).'/rst_examples/rst_base_handler.rst' );

$docbook = new ezcDocumentDocbook();
$docbook = $rstdoc->getAsDocbook();

// We store it in a new file
$myDocbookResult = fopen(dirname(__FILE__).'/result/convert_rst_docbook_result.xml', 'a+');
fputs($myDocbookResult, $docbook->save() );
fclose($myDocbookResult);

//var_dump($docbook->validateFile( dirname(__FILE__).'/convert_rst_docbook_result.xml' ));




/*
///////////////////////
// DOCBOOK TO EZXML //
/////////////////////


// Loading the document in Docbook format
$docbookToConvert = new ezcDocumentDocbook();
$docbookToConvert->loadFile( dirname(__FILE__).'/convert_rst_docbook_result.xml' );

// Preparing eZ XML File
$ezXml = new ezcDocumentEzXml();

// Transformation in ez xml file
$ezXml->createFromDocbook( $docbookToConvert );

// We store it in a new file
$myEZXmlResult = fopen(dirname(__FILE__).'/ezxml_result.xml', 'a+');
fputs($myEZXmlResult, $result );
fclose($myEZXmlResult);
$result = $ezXml->save();*/
