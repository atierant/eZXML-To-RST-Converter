<?php

require_once './src/tutorial/autoload.php';

// The eZ XML string is actually loaded and parsed into an internal abstract syntax tree
$document = new ezcDocumentEzXml();
$document->loadString( '<?xml version="1.0"?>
<section xmlns="http://ez.no/namespaces/ezpublish3">
    <header>Paragraph</header>
    <paragraph>Some content...</paragraph>
</section>');

// The internal structure is then transformed back to a docbook document
$docbook = $document->getAsDocbook();

// The resulting document is returned as a string, so that you can echo or store it
// echo $docbook->save();

// We store it in a new file
$myDocbookResult = fopen(dirname(__FILE__).'/01_convert_ezxml_docbook_result.xml', 'a+');
fputs($myDocbookResult, $docbook->save() );
fclose($myDocbookResult);
