<?php

require_once './src/tutorial/autoload.php';
$document = new ezcDocumentRst();

// Load custom Visitor
require dirname(__FILE__).'/myDocumentRstXhtmlVisitor.php';

// We define the option xhtmlVisitor with our new visitor class
$document->options->xhtmlVisitor = 'myDocumentRstXhtmlVisitor';

$document->loadFile( dirname(__FILE__).'/rst_document.rst' );
$xhtml = $document->getAsXhtml();
$xml = $xhtml->save();

// We store it in a new file
$myXhtmlResult = fopen(dirname(__FILE__).'/06_convert_rst_to_modified_xhtml.html', 'a+');
fputs($myXhtmlResult, $xml );
fclose($myXhtmlResult);
