<?php

require_once './src/project/autoload.php';

// Load custom class
require dirname(__FILE__).'/EzcDocumentEzXmlToRstConverter.php';

// Create a new empty ezc RST Document to fill with a RST File
$rstdoc = new ezcDocumentRst();

// Set our object to catch all errors during conversion
$rstdoc->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;

// Load the RST input into the set object
$rstdoc->loadFile( dirname(__FILE__).'/examples/rst/rst_base_handler.rst' );

// Create a new empty ezc EZ XML Document to fill with the return of the conversion
$myEZXmlResult = new ezcDocumentEzXml();

// Execute conversion
$myEZXmlResult = ezcDocumentEzXmlToRstConverter::convertRstToEzXml($rstdoc);

//var_dump($docbook->validateFile( dirname(__FILE__).'/convert_rst_docbook_result.xml' ));

// Store the result in a new file
//$myEZXmlResult = fopen(dirname(__FILE__).'/ezxml_result.xml', 'a+');
//fputs($myEZXmlResult, $result );
//fclose($myEZXmlResult);
//$result = $ezXml->save();


