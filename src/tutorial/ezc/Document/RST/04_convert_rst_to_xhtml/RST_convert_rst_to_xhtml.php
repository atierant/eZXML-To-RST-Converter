<?php

require_once './src/tutorial/autoload.php';
$document = new ezcDocumentRst();
$document->loadFile( dirname(__FILE__).'/rst_document.rst' );

// The internal structure is then transformed to a xhtml document
$xhtml = $document->getAsXhtml();
$xml = $xhtml->save();

// We store it in a new file
$myDocbookResult = fopen(dirname(__FILE__).'/04_convert_rst_to_xhtml.html', 'a+');
fputs($myDocbookResult, $xml );
fclose($myDocbookResult);
