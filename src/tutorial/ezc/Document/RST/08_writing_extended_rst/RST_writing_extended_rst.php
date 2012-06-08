<?php
require_once './src/tutorial/autoload.php';

// Loading the document in Docbook format
$docbook = new ezcDocumentDocbook();
$docbook->loadFile( dirname(__FILE__).'/address.xml' );

// Load custom AddressElementHandler
require dirname(__FILE__).'/myAddressElementHandler.php';

// Converting to RST
$rst = new ezcDocumentRst();

// Creating the handler
$converter = new ezcDocumentDocbookToRstConverter();
$converter->setElementHandler( 'docbook', 'address', new myAddressElementHandler() );

$rst = $converter->convert( $docbook );
$result = $rst->save();

// We store it in a new file
$myRstResult = fopen(dirname(__FILE__).'/08_writing_extended_rst.rst', 'a+');
fputs($myRstResult, $result );
fclose($myRstResult);


