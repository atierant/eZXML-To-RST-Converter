<?php

require_once './src/tutorial/autoload.php';

echo __FILE__;

/*
// Load custom directive
require './src/tutorial/RST/00_01_address_directive.php';

$document = new ezcDocumentRst();
$document->registerDirective( 'address', 'myAddressDirective' );
$document->loadFile( './src/tutorial/RST/RST_adress_directive.txt');

$docbook = $document->getAsDocbook();
echo $docbook->save();
*/
?> 
