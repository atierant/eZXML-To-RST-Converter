<?php

require_once './src/tutorial/autoload.php';
$document = new ezcDocumentRst();

// Specify that we only want an in-line xhtml block.
$document->options->xhtmlVisitor = 'ezcDocumentRstXhtmlBodyVisitor';

$document->loadFile( dirname(__FILE__).'/rst_document.rst' );

// The internal structure is then transformed to a xhtml document
$xhtml = $document->getAsXhtml();
$xml = $xhtml->save();

// We store it in a new file
$myXhtmlResult = fopen(dirname(__FILE__).'/05_convert_rst_to_xhtml_block.html', 'a+');
fputs($myXhtmlResult, $xml );
fclose($myXhtmlResult);
