<?php

require_once './src/tutorial/autoload.php';

// The document is actually loaded and parsed into an internal abstract syntax tree
$document = new ezcDocumentRst();

// Each parsing or compiling error will be transformed into an exception, so that you are noticed about those errors. The error reporting settings can be modified like for all other document handlers
$document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;

$document->loadFile( dirname(__FILE__).'/rst_base_handler.txt' );

// The internal structure is then transformed back to a docbook document
$docbook = $document->getAsDocbook();

// The resulting document is returned as a string, so that you can echo or store it
// echo $docbook->save();

// We store it in a new file
$myDocbookResult = fopen(dirname(__FILE__).'/01_convert_rst_docbook_result.xml', 'a+');
fputs($myDocbookResult, $docbook->save() );
fclose($myDocbookResult);
