<?php

require_once './src/project/autoload.php';

///////////////////////
// EZXML TO DOCBOOK //
/////////////////////


// The eZ XML string is actually loaded and parsed into an internal abstract syntax tree
$document = new ezcDocumentEzXml();

$document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;

/*
$document->loadString( '<?xml version="1.0"?>
<section xmlns="http://ez.no/namespaces/ezpublish3">
    <header>Paragraph</header>
    <paragraph>Some content...</paragraph>
</section>');*/

$document->loadFile( dirname(__FILE__).'/examples/ezxml/myEZXMLFile.xml' );


// The internal structure is then transformed back to a docbook document
$docbook = $document->getAsDocbook();

/////////////////////
// DOCBOOK TO RST //
///////////////////

// Converting to RST
$rst = new ezcDocumentRst();
$rst->createFromDocbook( $docbook );
$result = $rst->save();

// We store it in a new file
$myRstResult = fopen(dirname(__FILE__).'/result/rst_result.rst', 'a+');
fputs($myRstResult, $result );
fclose($myRstResult);


