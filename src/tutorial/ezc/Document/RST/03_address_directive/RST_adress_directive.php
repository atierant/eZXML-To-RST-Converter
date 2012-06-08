<?php

require_once './src/tutorial/autoload.php';

// Load custom directive
require dirname(__FILE__).'/AddressDirective.php';

$document = new ezcDocumentRst();

// Registering of the directive located in the class myAddressDirective (extending ezcDocumentRstDirective) of the file AddressDirective.php
$document->registerDirective( 'address', 'myAddressDirective' );

// Loading and parsing of the document into an internal abstract syntax tree, following the previous directives
$document->loadFile( dirname(__FILE__).'/RST_adress_directive.txt');

// The internal structure is then transformed back to a docbook document
$docbook = $document->getAsDocbook();

// The resulting document is returned as a string, so that you can echo or store it
// echo $docbook->save();

// We store it in a new file
$myDocbookResult = fopen(dirname(__FILE__).'/03_convert_with_directive_rst_docbook_result.xml', 'a+');
fputs($myDocbookResult, $docbook->save() );
fclose($myDocbookResult);
