<?php

require_once './src/tutorial/autoload.php';

// The document is actually loaded and parsed into an internal abstract syntax tree
$document = new ezcDocumentRst();

// The class myCustomDirective must extend the class ezcDocumentRstDirective, and implement the method toDocbook(). For rendering you get access to the full AST, the contents of the current directive and the base path, where the document resist in the file system - which is necessary for accessing external files.
$document->registerDirective( 'my_directive', 'myCustomDirective' );

// The document is actually loaded and parsed into an internal abstract syntax tree
$document->loadFile( './src/tutorial/RST/RST_tuto_directives.txt' );

// The internal structure is then transformed back to a docbook document
$docbook = $document->getAsDocbook();


$xml = $docbook->save();
?> 
