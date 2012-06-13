<?php

>$classes = array(
    'rst'     => 'ezcDocumentRst',
    'docbook' => 'ezcDocumentDocbook',
    'creole'  => 'ezcDocumentWiki',
    'xhtml'   => 'ezcDocumentXhtml',
    'ezxml'   => 'ezcDocumentEzXml',
);

$sourceClass = $classes[$from];
$source = new $sourceClass();
$source->options->errorReporting = E_PARSE;
$source->loadString( $text );

$destinationClass = $classes[$to];
$destination = new $destinationClass();
$destination->options->errorReporting = E_PARSE;
$destination->createFromDocbook( $source->getAsDocbook() );

echo $destination;
